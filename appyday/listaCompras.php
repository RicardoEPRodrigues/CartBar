<!DOCTYPE html>
<html lang="pt-PT" xml:lang="pt-PT">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8_general_ci"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CartBar</title>
        <script src="jquery-ui/js/jquery-2.0.3.js"></script>
        <script src="js/jquery.filtertable.min.js"></script>
        <script src="jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>
        <link type="text/css" rel="stylesheet"
              href="jquery-ui/css/dark-hive/jquery-ui-1.10.3.custom.min.css"/>
        <link rel="stylesheet" href="css/pure-min.css">
        <link rel="stylesheet" href="css/side-menu.css">
        <style>
            .clickableRow {
                cursor: pointer;
            }
        </style>
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
        $_SESSION["dblocal"] = "db.ist.utl.pt";
        $_SESSION["user"] = "ist173997";
        $_SESSION["pass"] = "zsfs3763";
        $_SESSION["db"] = "ist173997";
        if($_SESSION['client'] != null) {
            if($_REQUEST['nomePrato'] != null && $_REQUEST['categoriaPrato'] != null && $_REQUEST['quantidade'] != null) {
                $connection = mysqli_connect($_SESSION["dblocal"], $_SESSION["user"], $_SESSION["pass"], $_SESSION["db"]);
                $stmt = $connection->prepare("INSERT INTO Carrinho VALUES ( ? , ? , ? , ?, 'pedido' ) ;");
                $stmt->bind_param('sssd', $_SESSION['client'], $_REQUEST['nomePrato'], $_REQUEST['categoriaPrato'], $_REQUEST['quantidade'] );
                $stmt->execute();
            }
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
                <img src="images/cartabar_logo2.png" style="height: 2cm;">
            </div>
            <div class="content">
                <div class="pure-u-1" style="margin: 0.5cm;">
                <?php
                    session_start();
                    $connection = mysqli_connect($_SESSION["dblocal"], $_SESSION["user"], $_SESSION["pass"], $_SESSION["db"]);
                    $pedidos = mysqli_query($connection, "SELECT DISTINCT nome, produtosQTD, preco FROM Carrinho NATURAL JOIN Produtos WHERE status = 'pedido' ORDER BY nome;");

                    echo '<table class="pure-table"><thead><tr><th>Nome</th><th>Quantidade</th><th>Pre&ccedil;o unit&aacute;rio</th></tr><tboby>';
                    while($row = mysqli_fetch_row($pedidos)) {
                        if($i % 2 == 0) {
                            echo '<tr class="pure-table-odd">';
                        }
                        else {
                            echo '<tr>';
                        }
                        echo '<td>'.$row[0].'</td>'.'<td>'.$row[1].'</td>'.'<td>'.number_format($row[2], 2).'&euro;</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';

                    mysqli_close($connection);
                ?>
            </div>
                <form action="pagar.php" method="post" class="pure-form pure-form-aligned">
                    <fieldset>
                        <button class="pure-button pure-button" onclick="history.go(-1);return false;">Voltar</button>
                        <input type="hidden" name="pedir" value="1">
                        <button type="submit" class="pure-button pure-button-primary">Pedir tudo</button>
                    </fieldset>
                </form>
            </div>
        </div>
        <script src="js/ui.js"></script>
    </body>
</html>
