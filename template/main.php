<!doctype html>
<html lang="ru">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link href="<?= \core\Router::root() ?>/template/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?= \core\Router::root() ?>/template/css/main.css" rel="stylesheet" type="text/css"/>

        <title>Comments</title>
        <style>
            table {
                text-align: left;
            }
            nav {
                margin-bottom: 15px;
            }
            .in-line {
                white-space: nowrap;
            }

            .rightbutton {
                position: absolute; 
                top: 10px; 
                right: 10px;                
            }
            .cell-length{
                width: 85px;
            }
        </style>
        <script src="<?= \core\Router::root() ?>/template/js/main.js" type="text/javascript"></script>
    </head>
    <body>
        <main>
            <?php include_once 'template' . DIRECTORY_SEPARATOR . $this->content_view; ?>
        </main>
        <!-- Footer -->
        <footer>
            <!-- Copyright -->
            <div class="footer-copyright text-center py-3">© 2020 Copyright:
                <a href="#"  target="_blank">qqq</a>
            </div>
            <!-- Copyright -->
        </footer>
        <!-- Footer -->

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="<?= \core\Router::root() ?>/template/js/bootstrap.min.js" type="text/javascript"></script>  
        <script src="<?= \core\Router::root() ?>/template/js/jquery.maskedinput.min.js" type="text/javascript"></script>
        <script src="<?= \core\Router::root() ?>/template/js/jquery-validate.bootstrap-tooltip.min.js" type="text/javascript"></script>  
        <script src="<?= \core\Router::root() ?>/template/js/main.js" type="text/javascript"></script>
    </body>
</html>