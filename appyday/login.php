<!DOCTYPE html>
<html lang="pt-PT" xml:lang="pt-PT">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8_general_ci"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CartBar - Iniciar Sess&atilde;o</title>
        <link rel="icon" href="images/icon.png">
        <script src="jquery-ui/js/jquery-2.0.3.js"></script>
        <script src="jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>
        <link type="text/css" rel="stylesheet"
              href="jquery-ui/css/dark-hive/jquery-ui-1.10.3.custom.min.css"/>
        <link type="text/css" rel="stylesheet"
              href="barista.css"/>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.3.0/pure-min.css">
        <link rel="stylesheet" href="css/side-menu.css">
    </head>
    <body>
        
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/pt_PT/all.js#xfbml=1";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        
    <?php
    session_start();
    switch( $_REQUEST['state'])
    {
        case "login":
            $email = $_REQUEST["email"];
            $pass = $_REQUEST["password"];
            if( $pass != null && $email != null) {
                $connection = new mysqli($_SESSION["dblocal"], $_SESSION["user"], $_SESSION["pass"], $_SESSION["db"]);
                $stmt = $connection->prepare("SELECT DISTINCT Count(*) FROM Clientes WHERE email = ? AND pass = ? ;");
                $stmt->bind_param("ss", $email, $pass);
                if($stmt->execute()) {
                    $stmt->bind_result($userInDb);
                    $stmt->fetch();
                    if($userInDb > 0) {
                        $_SESSION["client"] = $email;
                        $_SESSION["loginerrado"] = null;
                    }
                    else {
                        $_SESSION["loginerrado"] = 1;
                    }
                }
                $connection->close();
            }
            break;
        case "logout":
            $_SESSION['client'] = null;
            break;
        case "newpassword":
            $client = $_SESSION['client'];
            $actPass = $_REQUEST['actPass'];
            $newPass = $_REQUEST['newPass'];
            if($client != null && $actPass != null && $newPass != null) {
                $_SESSION['newpassword'] = -1;
                $connection = new mysqli($_SESSION["dblocal"], $_SESSION["user"], $_SESSION["pass"], $_SESSION["db"]);
                
                $stmt = $connection->prepare("SELECT COUNT(*) FROM Clientes WHERE email = ? AND pass = ?;");
                $stmt->bind_param("ss", $client, $actPass);
                if($stmt->execute()) {
                    $stmt->bind_result($count);
                    $stmt->fetch();
                    if($count > 0) {
                        $stmts = $connection->prepare("UPDATE Clientes SET pass = ? WHERE email = ? AND pass = ?;");
                        $stmts->bind_param("sss", $newPass, $client, $newPass);
                        if(!$stmts->execute()) {
                            echo('<h1> ERROR </h1>');
                        }
                        else $_SESSION['newpassword'] = 1;
                    }
                }
                $connection->close();
            }
            break;
        case "register":
            $nome = $_REQUEST["nome"];
            $email = $_REQUEST["email"];
            $pass = $_REQUEST["password"];
            if($nome != null && $pass != null && $email != null){
                $connection = new mysqli($_SESSION["dblocal"], $_SESSION["user"], $_SESSION["pass"], $_SESSION["db"]);
                $stmt = $connection->prepare("INSERT INTO Clientes(email, nome, pass, confirmado, confirmacao) VALUES (?, ?, ?, true, 'qwer');");
                $stmt->bind_param("sss", $email, $nome, $pass);
                if($stmt->execute()) {
                    $_SESSION["client"] = $email;
                    $_SESSION["loginerrado"] = null;
                }
                $connection->close();
            }
            break;
        default:
            break;
    }
    ?>
        
        
    <div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="pure-menu-link">
        <!-- Hamburger icon -->
        <span></span>
    </a>

    <div id="menu">
            <div class="pure-menu pure-menu-open">
                <a class="pure-menu-heading" href="menuEmenta.php">Cart Bar</a>

                <ul>
                    <?php 
                        session_start();
                        if( $_SESSION["client"] != null ) {
                            echo '<li><a href="login.php">Defini&ccedil;&otilde;es de conta</a></li>';
                            echo '<li><a href="listaCompras.php">Enviar pedido</a></li>';
                            echo '<li><a href="pagar.php">Pagar pedido</a></li>';
                            echo '<li><a href="historico.php">Hist&oacute;rico</a></li>';
                            echo '<div class="fb-share-button" data-href="http://web.ist.utl.pt/ist173997/appyday/menuEmenta.php" data-type="button_count"></div>';
                        }
                        else {
                            echo '<li><a href="login.php">Iniciar Sess&atilde;o</a></li>';
                            echo '<div class="fb-share-button" data-href="http://web.ist.utl.pt/ist173997/appyday/menuEmenta.php" data-type="button_count"></div>';
                        }
                    ?>
                </ul>
            </div>
        </div>
    
    <div id="main">
        <div class="header">
            <?php
            session_start();
            if($_SESSION["client"] != null) {
                $connection = new mysqli($_SESSION["dblocal"], $_SESSION["user"], $_SESSION["pass"], $_SESSION["db"]);
                $stmt = $connection->prepare("SELECT nome FROM Clientes WHERE email = ?;");
                $stmt->bind_param("s", $_SESSION["client"]);
                if($stmt->execute()) {
                    $stmt->bind_result($userInDb);
                    $stmt->fetch();
                    echo('<h1>Benvindo '.$userInDb.'!</h1>');
                }
            }
            else {
                echo('<h1>In&iacute;cio de Sess&atilde;o</h1>');    
            }
            ?>
        </div>
        <div class="content" style=
            <?php
                session_start();
                if($_SESSION["dblocal"] == null) {
                    $_SESSION["dblocal"] = "db.ist.utl.pt";
                    $_SESSION["user"] = "ist173997";
                    $_SESSION["pass"] = "zsfs3763";
                    $_SESSION["db"] = "ist173997";
                }
                if($_SESSION["client"] != null) {
                    echo( '"display : none;"' );
                }
                else {
                    echo( '"display : block;"' );
                }
            ?>>
            <?php
                session_start();
                if($_SESSION["loginerrado"] == 1) {
                    echo('<h2 class="content-subhead" style="color: red">N&atilde;o foi poss&iacute;vel a liga&ccedil;&atilde;o com a sua conta.</h2>');
                    echo('<h3 class="content-subhead" style="color: red">Por favor verifique o seu email e palavra passe.</h3>');
                }
            ?>
            <form action="login.php" method="post" class="pure-form pure-form-aligned">
                <fieldset>
                    <input type="hidden" name="state" value="login">
                    <legend style="text-align: center;">Iniciar Sess&atilde;o</legend>
    
                    <div class="pure-control-group">
                        <label for="email">Email</label>
                        <input type="email" placeholder="Email" name="email">
                    </div>
                    
                    <div class="pure-control-group">
                        <label for="password">Password</label>
                        <input type="password" placeholder="Password" name="password">
                    </div>
            
                    <div class="pure-controls">
                        <button type="submit" class="pure-button pure-button-primary">Entrar</button>
                    </div>
                </fieldset>
            </form>
            <h2 class="content-subhead" style="text-align: center">OU</h2>
            <form action="login.php" method="post" class="pure-form pure-form-aligned">
                <input type="hidden" name="state" value="register">
                <fieldset>
                    <legend style="text-align: center;">Registar</legend>
    
                    <div class="pure-control-group">
                        <label for="email">Nome</label>
                        <input type="text" placeholder="Nome" name="nome">
                    </div>
                    
                    <div class="pure-control-group">
                        <label for="email">Email</label>
                        <input type="email" placeholder="Email" name="email">
                    </div>
                    
                    <div class="pure-control-group">
                        <label for="password">Password</label>
                        <input type="password" placeholder="Password" name="password">
                    </div>
                    <div class="pure-controls">
                        <button type="submit" class="pure-button pure-button-primary">Registar</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="content" style=
            <?php
                session_start();
                $_SESSION["dblocal"] = "db.ist.utl.pt";
                $_SESSION["user"] = "ist173997";
                $_SESSION["pass"] = "zsfs3763";
                $_SESSION["db"] = "ist173997";
                if($_SESSION["client"] == null) {
                    echo( '"display : none;"' );
                }
                else {
                    echo( '"display : block;"' );
                }
            ?>>
            <?php 
                if($_SESSION['newpassword'] == -1) {
                    echo('<h2 class="content-subhead" style="color: red">N&atilde;o foi poss&iacute;vel a altera&ccedil;&atilde;o da palavra passe.</h2>');
                    echo('<h3 class="content-subhead" style="color: red">Por favor verifique a sua palavra passe.</h3>');
                    $_SESSION['newpassword'] = 1;
                }
            ?>
            <form action="login.php" method="post" class="pure-form pure-form-aligned">
                <fieldset>
                    <input type="hidden" name="state" value="newpassword">
                    <legend>Alterar Palavra Passe</legend>
    
                    <div class="pure-control-group">
                        <label for="actPass">Palavra Passe Actual</label>
                        <input type="password" placeholder="Palavra Passe Actual" name="actPass">
                    </div>
                    
                    <div class="pure-control-group">
                        <label for="password">Nova Palavra Passe</label>
                        <input type="password" placeholder="Nova Palavra Passe" name="newPass">
                    </div>
            
                    <div class="pure-controls">
                        <button type="submit" class="pure-button pure-button-primary">Submeter</button>
                    </div>
                </fieldset>
            </form>
            <form action="login.php" method="post" class="pure-form pure-form-aligned">
                <fieldset>
                    <input type="hidden" name="state" value="logout">
                    <div class="pure-controls">
                    <button type="submit" class="pure-button pure-button-primary">Sair da Conta</button>
                    </div>
                </fieldset>
            </form>
        </div>
        </div>
        </div>
        <script src="js/ui.js"></script>
    </body>
</html> 