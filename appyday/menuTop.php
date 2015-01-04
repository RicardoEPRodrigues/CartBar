<!DOCTYPE html>
<html lang="pt-PT" xml:lang="pt-PT">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8_general_ci"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CartBar - Restaura&ccedil;&atilde;o</title>
        <link rel="icon" href="images/icon.png">
        <script src="jquery-ui/js/jquery-2.0.3.js"></script>
        <script src="   js/jquery.filtertable.min.js"></script>
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
        ?>
    
        <?php
            session_start();
            $_SESSION["email"] = $_REQUEST["email"];
            $_SESSION["userpass"] = $_REQUEST["pass"];
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
                <div class="pure-g">
                    <div class="pure-menu pure-menu-open pure-menu-horizontal pure-u-1">
                        <ul>
                            <li id="menu-1"><a href="menuEmenta.php">Aperitivos</a></li>
                            <li id="menu-2"><a href="menuPromocoes.php">Cafetaria</a></li>
                            <li id="menu-3"><a href="menuNovidades.php">Pastelaria</a></li>
                            <li id="menu-4" class="pure-menu-selected"><a href="#">Restauracao</a></li>
                        </ul>

                    </div>
                </div>
            <div class="pure-g-r">
                <div class="pure-u-1">
                    <form class="pure-form" style="margin: 1cm;">
                        <input id="pesquisa" type="text" class="pure-input-rounded" placeholder="Pesquisa">
                    </form>            
                    <script>
            jQuery.expr[':'].Contains = function(a, i, m) {
                return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
            };
            $("#pesquisa").keyup(function () {
                var unicode = event.charCode ? event.charCode : event.keyCode;
                if (unicode == 27) { $(this).val(""); }
                var data = this.value.split(" ");
                var tbl = $("#produtos-tbody").find("tr");
                if (this.value == "") {
                    tbl.show();
                    return;
                }
                tbl.hide();
                tbl.filter(function (i, v) {
                    var t = $(this);
                    for (var d = 0; d < data.length; ++d) {
                        if (t.is(":Contains('" + data[d] + "')")) {
                            return true;
                        }
                    }
                    return false;
                }).show();
            });
            </script>
                </div>
            
            <div id="indexacao" class="pure-u-1" style="margin: 0.5cm;">
                <script>
                jQuery(document).ready(function($) {
                    $(".clickableRow").click(function(event) {
                        window.document.location = $(this).attr("href");
                    });
                    $('table').filterTable();
                });
                
                <?php
                session_start();
                $connection = mysqli_connect($_SESSION["dblocal"], $_SESSION["user"], $_SESSION["pass"], $_SESSION["db"]);

                $echoCats = "var categorias = [";
                $echoElems = "var produtos = [";
                $cats = mysqli_query($connection, "SELECT DISTINCT categoria FROM Produtos ORDER BY categoria;");

                $numOfRowsOnCats = mysqli_num_rows($cats);
                while($row = mysqli_fetch_row($cats)) {
                    $echoCats .= "\"".$row[0]."\"";
                    $numOfRowsOnCats -= 1;
                    if( !($numOfRowsOnCats == 0) ) {
                        $echoCats .= ",\n";
                    }
                    $echoElems .= "[";
                    $elems = mysqli_query($connection, "SELECT nome, preco, descricao, pathImg FROM Produtos WHERE categoria=\"".$row[0]."\" ORDER BY nome;");
                    $numOfRowsOnElems = mysqli_num_rows($elems);
                    while($row = mysqli_fetch_row($elems)) {
                        $echoElems .= "[\"".$row[0]."\",".$row[1].",\"".$row[2]."\",\"".$row[3]."\"]";
                        $numOfRowsOnElems -= 1;
                        if( !($numOfRowsOnElems == 0) ) {
                            $echoElems .= ",\n";
                        }
                    }
                    $echoElems .= "]";
                    if( !($numOfRowsOnCats == 0) ) {
                        $echoElems .= ",\n";
                    }

                }
                $echoCats .= "];\n";
                $echoElems .= "];\n";

                mysqli_close($connection);

                echo $echoCats;
                echo $echoElems;
                ?>
                var div = "<div><table id=\"produtos-table\" class=\"pure-table\"><thead><tr><th scope=\"col\"></th><th scope=\"col\">Nome</th><th scope=\"col\">Pre&ccedil;o</th></tr></thead><tbody id=\"produtos-tbody\">";
                var i = 3 >= categorias.length ? categorias.length-1 : 3;
                for(var j = 0; j < produtos[i].length; j++) {
                    if(j % 2 === 0) {
                        div += "<tr href=\"product.php?producto=" + encodeURIComponent(produtos[i][j][0]) + "\" class=\"clickableRow pure-table-odd\">";
                    }
                    else {
                        div += "<tr href=\"product.php?producto=" + encodeURIComponent(produtos[i][j][0]) + "\" class=\"clickableRow\">";
                    }
                    div += "<td><img style=\"height:1cm;width:1cm;\" src=\""+produtos[i][j][3]+"\" alt=\"\"></td>";
                    div += "<td>"+produtos[i][j][0]+"</td>";
                    div += "<td>"+produtos[i][j][1].toFixed(2)+"\u20ac</td>";
                    //div += "<td>"+produtos[i][j][2]+"</td>";
                    div += "</tr>";
                }
                div += "</tbody></table></div>";
                $("#indexacao").append(div);
                $("#produtos-table").filterTable();
                </script>
            </div>
                </div>
        </div>
        </div>
        </div>
        <script src="js/ui.js"></script>
    </body>
</html>
