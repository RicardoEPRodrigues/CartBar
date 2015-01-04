<!DOCTYPE html>
<html lang="pt-PT" xml:lang="pt-PT">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8_general_ci"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CartBar - Info Produto</title>
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
        <?php 
            session_start();
            $connection = mysqli_connect($_SESSION["dblocal"], $_SESSION["user"], $_SESSION["pass"], $_SESSION["db"]);
            $stmt = $connection->prepare("SELECT * FROM Produtos WHERE nome = ? ;");
            $stmt->bind_param('s', $nomex);
            $nomex = $_GET['producto'];
            if($stmt->execute()) {
                
                $stmt->bind_result($categoria, $nome, $preco, $descricao, $path );
                $stmt->fetch();
//                while ($stmt->fetch())
//                {
//                    echo('<p> '.$_GET['producto'].' 2 </p>');
//                }
                
                if($nome != null) {
                    echo('<div class="header">');
                    echo('<h1>'.$nome.'</h1>');
                    if($path != null) {
                        echo('<img style="width: 3cm; height: 3cm" src="'.$path.'" alt="'.$nome.'">');
                    }
                    echo('</div>');
                    
                    echo('<div class="content">');
                    
                    if($descricao != null) {
                        echo('<h2 class="content-subhead">Descri&ccedil;&atilde;o</h2>');
                        echo('<p>'.$descricao.'</p>');
                    }
                    
                    echo('<h2 class="content-subhead">Pre&ccedil;o : '.$preco.' &euro;</h2>');
                    // ADICIONAR O SHARE DO FACE
                    // ADICIONAR A QUANTIDADE NO PEDIDO
                    
                    if($_SESSION['client'] != null) {
                        echo('<form action="listaCompras.php" method="post" class="pure-form pure-form-aligned">');
                        echo('<fieldset>
                        <input type="hidden" name="nomePrato" value="'.$nome.'">
                        <input type="hidden" name="categoriaPrato" value="'.$categoria.'">
                        <h2 class="content-subhead" for="quanti">Quantidade a adicionar :
                            <select name="quantidade" id="quanti">
                            <option value="1">1 Unidade</option>
                            <option value="2">2 Unidades</option>
                            <option value="3">3 Unidades</option>
                            <option value="4">4 Unidades</option>
                            <option value="5">5 Unidades</option>
                            <option value="6">6 Unidades</option>
                            <option value="7">7 Unidades</option>
                            <option value="8">8 Unidades</option>
                            <option value="9">9 Unidades</option>
                            <option value="10">10 Unidades</option>
                            </select>
                        </h2>
                        <button class="pure-button" onclick="history.go(-1);return false;">Voltar</button>
                        <button type="submit" class="pure-button pure-button-primary">Adicionar</button>
                        </fieldset>');
                        echo('</form>');
                    }
                    else {
                        echo('<button class="pure-button pure-button" onclick="history.go(-1);return false;">Voltar</button>');
                        echo('<h2 class="content-subhead" for="quanti"><a href="login.php">Inicie sess&atilde;o</a> para  poder encomendar este produto.</h2>');
                    }
                    echo('</div>');
                }
            }
        ?>
    </div>
    </div>
    <script src="js/ui.js"></script>
</body>
</html>