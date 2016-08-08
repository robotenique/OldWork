<?php

session_start();

/**VERIFICA��ES DA SESSION **/
	$dirs = array_filter(glob('colecoes/*'), 'is_dir');
    $numDir = count($dirs);
    $numColec = sprintf("%03d", $numDir); //Muda o formato. Ex: Se o numero for '1', ele muda para '001'. NumColec � o n�mero da maior cole��o (mais recente).
if ((!isset($_REQUEST['colecAtual']))) {     
    $colecAtual = $numColec;
} elseif((strcmp($_REQUEST['colecAtual'], "nenhuma") == 0)|| empty($_REQUEST['colecAtual'])||$_REQUEST['colecAtual']==0) {
    $colecAtual = $numColec;}
	elseif($_REQUEST['colecAtual']>$numColec){
	$colecAtual = $numColec;
	}
	else{
    $colecAtual = $_REQUEST['colecAtual'];
}


$caminhoDirColec = "colecoes/colec" . $colecAtual;
$caminhoTxt = $caminhoDirColec . "/colec.txt";
$arquivoColec = fopen($caminhoTxt, 'r');
$colec = array();
while (!feof($arquivoColec)) {
    $colec[] = fgets($arquivoColec);
}
fclose($arquivoColec);
$nomeColec = $colec[0]; //Nome da Cole褯
$nomeDono = $colec[1];  //Nome do Autor
$descColec = $colec[2]; //Descri褯 da Cole褯  
//Fotos da cole褯
$imagens = glob($caminhoDirColec . "/" . "*.{gif,jpg,png}", GLOB_BRACE);
$qtdFotos = count($imagens);
natsort($imagens);
$x = 0;

/* <?php 
  }?> */


echo '<html>
	<head>
	<link rel="favicon" href="favicon.ico" type="image/x-icon" />
		<title>Coleção</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900" rel="stylesheet" type="text/css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>		
		<script src="js/init.js"></script>
		<noscript>			
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
            <link rel="stylesheet" href="css/main.css" />
		</noscript>
	</head>
	<body>

	<!-- Header -->
		<div id="header">
			<div id="nav-wrapper"> 
				<!-- Nav -->
				<nav id="nav">
					<ul>
						<li><a href="index.php">Homepage</a></li>
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
	<!-- Header -->
        <!-- Main -->
		<div id="main">
			<div id="content" class="container">
				<section>
					<header>
						<h2>' . $nomeColec . '</h2><br> <br>
                                                <h1>' . $nomeDono . '</h1>
						<span class="byline">' . $descColec . ' </span>
					</header>
				</section> <br>';

while ($x < $qtdFotos) {

    echo'  <div class = "row">
                      <section class = "6u">
                      <img src = "' . $imagens[$x] . '" alt = "' . $descColec . '"/>
					  
                      </section>';
    $x = $x + 1;
    if ($x < $qtdFotos) {
        echo'  
                      <section class = "6u">
                      <img src = "' . $imagens[$x] . '" alt = "' . $descColec . '"/>
					  
                      </section>
                      </div>';
        $x = $x + 1;
    } else {
        echo ' </div> ';
        break;
    }
}

echo '</div>
                </div>
     </body>
</html>';
?>