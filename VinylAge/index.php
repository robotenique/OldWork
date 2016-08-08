<!DOCTYPE HTML>
<html>
    <head>
    <link rel="favicon" href="favicon.ico" type="image/x-icon" />
        <title>VinylAge</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900' rel='stylesheet' type='text/css'>
        <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
        <script src="js/skel.min.js"></script>
        <script src="js/skel-panels.min.js"></script>
        <script src="js/init.js"></script>
        <noscript>
        <link rel="stylesheet" href="css/skel-noscript.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/style-desktop.css" />
        </noscript>
    </head>
    <body class="homepage">

        <!-- Header -->
        <div id="header">
            <div id="nav-wrapper">
                <!-- Nav -->
                <nav id="nav">
                    <ul>
                        <li class="active"><a href="index.php">Home</a></li>
                        <li><a href="upload.form.php">Envie sua coleção</a></li>
                    </ul>
                </nav>
            </div>
            <div class="container">

                <!-- Logo -->
                <div id="logo">
                    <h1><a href="#">Vinyl Age</a></h1>
                    <span class="tag">Por Guilherme Inuy e Juliano Garcia</span>
                </div>
            </div>
        </div>

        <!-- Main -->
        <div id="main">
            <div id="content" class="container">

                <?php
                session_start("colecoes");
                $_SESSION["colecAtual"] = "nenhuma";

                $files = glob("thumbnails/*.*");
                $count = count($files);
                natsort($files);
                /* for ($x = 0; $x <= $count; $x=$x+2) {

                  } */
                $x = 0;
                while ($x < $count) {
                    $numColec = substr($files[$x], -7,3); //Retorna o número da coleção!
                    $caminhoColec ="colecoes/colec".$numColec."/colec.txt" ;
                    $arquivoColec = fopen($caminhoColec,'r');
                    $colec = array();
                    while(!feof($arquivoColec)){
                        $colec[]=  fgets($arquivoColec);
                    }
                    fclose($arquivoColec);
                    $nomeColec = $colec[0];
                    $nomeDono = $colec[1];
                    $descColec = $colec[2];

                    echo '<div class="row">
					<section class="6u">
						<a href="colecao.php?colecAtual='.$numColec.'" class="image full"><img src="' . $files[$x] . '" alt="'.$descColec.'"></a>
						<header>
							<h2>'.$nomeColec.'</h2>
						</header>
                                            <p>'.$nomeDono.'</p>
                                            </section>';
                    $x = $x + 1;
                    if ($x < $count) {
                        $numColec = substr($files[$x], -7,3); //Retorna o número da coleção!
                        
                    $caminhoColec ="colecoes/colec".$numColec."/colec.txt" ;
                    $arquivoColec = fopen($caminhoColec,'r');
                    $colec = array();
                    while(!feof($arquivoColec)){
                        $colec[]=  fgets($arquivoColec);
                    }
                    fclose($arquivoColec);
                    $nomeColec = $colec[0];
                    $nomeDono = $colec[1];
                    $descColec = $colec[2];
                        echo '<section class="6u">
						<a href="colecao.php?colecAtual='.$numColec.'" class="image full"><img src="' . $files[$x] . ''
                                . '" alt="'.$descColec.'"></a>
						<header>
							<h2>'.$nomeColec.'</h2>
						</header>
						<p>'.$nomeDono.'</p>
					</section>
				</div>';
                        $x = $x + 1;
                    } else {
                        echo '</div>';
                        break;
                    }
                }
                ?>


            </div>
        </div>
    </body>
</html>