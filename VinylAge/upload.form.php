<?php
/** Retorna todas as pastas dentro da pasta 'colecoes' * */
$dirs = array_filter(glob('colecoes/*'), 'is_dir');
$proxDir = count($dirs) + 1;
$numColec = sprintf("%03d", $proxDir); //Muda o formato. Ex: Se o numero for '1', ele muda para '001'
$novoDir = "colecoes/" . "colec" . $numColec; //Forma a String da pasta da coleção atual!!
/** Verifica se a pasta especificada já existe. Se não existir, cria uma nova! * */
$thumb_dir = "thumbnails/";
$tamanho_max_arquivo = 3000000; // tamanho em bytes
error_reporting(E_ALL);
/* * * numeros de arquivos para upload ** */
$num_uploads = 6;
/* * * tamanho maximo de upload dos arquivos (em bytes) ** */
$max_file_size = 512000;
/* * * mensagem p/ usuario ** */
$msg = '';
/* * * Array para receber msgs ** */
$messages = array();
/* * * verificação de erros no array de arquivos ** */
if (isset($_FILES['userfile']['tmp_name'])) {
    if (!file_exists($novoDir)) {
        mkdir($novoDir, 0777, true);
    }

    $upload_dir = $novoDir . "/";
    if (isset($_REQUEST["nomeColecao"]) && isset($_REQUEST["nomeDono"]) && isset($_REQUEST["descColecao"])) {
        $nomeColecao = $_REQUEST["nomeColecao"];
        $nomeDono = $_REQUEST["nomeDono"];
        $descColecao = $_REQUEST["descColecao"];
        $caminhoTxt = $upload_dir . "colec.txt";
        $arquivoColecao = fopen($caminhoTxt, "w");
       // fwrite($arquivoColecao, pack("CCC",0xef,0xbb,0xbf)); 
         fwrite($arquivoColecao, "\xEF\xBB\xBF");
        fwrite($arquivoColecao, $nomeColecao . "\n");
        fwrite($arquivoColecao, $nomeDono . "\n");
        fwrite($arquivoColecao, $descColecao . "\n");
        fclose($arquivoColecao);
    }
    /** loop através do array de arquivos ** */
    $thumbnail = true;
    for ($i = 0; $i < count($_FILES['userfile']['tmp_name']); $i++) {
        /*         * * verifica se há arquivos no upload ** */
        if (!is_uploaded_file($_FILES['userfile']['tmp_name'][$i])) {
            $messages[] = 'Nenhum arquivo selecionado';
        }        
        /*         * * verifica se o tamanho do arquivo é menor do o max_file_size *///
        elseif ($_FILES['userfile']['size'][$i] > $max_file_size) {
            $messages[] = "O tamanho do arquivo excede o tamanho máximo permitido";
        } else {
            /*             * * copia o arquivo para o dir especificado  ** */
            if (@copy($_FILES['userfile']['tmp_name'][$i], $upload_dir . "foto" . $i . "." .
                            pathinfo($_FILES['userfile']['name'][$i], PATHINFO_EXTENSION))) {
                /*                 * * mostra que o arquivo sofreu upload. ** */
                $messages[] = $_FILES['userfile']['name'][$i] . ' foi adicionado à coleção!';

                if ($thumbnail) {
                    @copy($_FILES['userfile']['tmp_name'][$i], $thumb_dir . "capa" . $numColec . "." .
                                    pathinfo($_FILES['userfile']['name'][$i], PATHINFO_EXTENSION));
                    $thumbnail = false;
                }
            } else {
                /*                 * * mensagem de erro ** */
                $messages[] = 'Upload de  ' . $_FILES['userfile']['name'][$i] . ' Falhou';
            }
        }
    }
} //FIM DO IF
?>
<!DOCTYPE HTML>
<html>
    <head>
<link rel="favicon" href="favicon.ico" type="image/x-icon" />
        <title>Envie sua Coleção</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,700,500,900' rel='stylesheet' type='text/css'>

        <script src="js/skel.min.js"></script>
        <script src="js/skel-panels.min.js"></script>
        <script src="js/init.js"></script>
        <noscript>
        <link rel="stylesheet" href="css/skel-noscript.css" />
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
                        <h2>Envie Sua Coleção!</h2>
                    </header>
                    <p>                    
                    <form  action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" 					  
                           enctype="multipart/form-data" method="post"> 
                        <p> 
                            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />					  
                        </p>
                        Nome da coleção: <input type="text"  placeholder="Digite um nome para a coleção" name="nomeColecao" required  maxlength="70"> <br><br>


                        Seu nome:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text"   placeholder="Digite seu nome" name="nomeDono" required  maxlength="40">
                        <br><br>

                        Descrição: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <textarea  required placeholder="Digite uma breve descrição da sua coleção" name="descColecao" maxlength="300"></textarea> 
                        <br><br>


                        <p> 
                            <label for="file">Imagens da coleção (Tamanho Máximo 5 MB):</label>
                            <?php
                            $num = 0;
                            while ($num < $num_uploads) {

                                echo '<div class="fileinput"><input name="userfile[]" type="file" accept="image/*"/></div>';
                                $num++;
                            }
                            ?>	                                       
                        </p> 

                        <p> 
                            </br><br><br>
                            <br>
                            <br>



                            <input id="submit" type="submit" name="submit" value="Enviar coleção">    </p>
                        <h3><?php echo $msg; ?></h3>
                        <?php
                        if (sizeof($messages) != 0) {
                            echo '<span style=" font-size:20px;"> Aviso: </span>';
                            echo '<span style=" font-size:20px;"> Redirecionando para página inicial em 10 segundos... </span><br />';
                            header("refresh:10; url=index.php");
                            foreach ($messages as $err) {
                                echo '<span id="contErr" >' . $err . ' </span><br />';
                            }
                        }
                        ?>

                    </form>  
                </section>
            </div>

        </div>
        <!-- /Main -->




    </body>
</html>