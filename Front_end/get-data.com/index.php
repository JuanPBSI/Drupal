<?php
    $sitio=intval($_GET["Sitio"]);
    $nodo=intval($_GET["Nodo"]);
    $username = "jesus";
    $password = "chucho123.,";

    // Peticion Sitio1 : Comentarios
    $server = 'http://back-end.com/site'.$sitio.'/rest/coment/'.$nodo;
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $server);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    $json_comment=curl_exec($ch);
    curl_close($ch);
	$obj_comment = json_decode($json_comment);

	// Peticion Sitio1 : Nodo
    $server = 'http://back-end.com/site'.$sitio.'/rest/nodo/'.$nodo;
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $server);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    $json_nodo=curl_exec($ch);
    curl_close($ch);
	$obj_nodo = json_decode($json_nodo);

	// Peticion Sitio1 : Imagen
    $server = 'http://back-end.com/site'.$sitio.'/rest/img/'.$nodo;
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $server);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    $json_img=curl_exec($ch);
    curl_close($ch);
	$obj_img = json_decode($json_img);

	if (empty($obj_nodo)) {
		exit("No existe ese registro en el back-end");
	}
	#print($obj_img->{'1'}->{'img_filename'});
?>

<?xml version="1.0" encoding="utf-8"?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.1//EN"
    "http://www.w3.org/TR/xhtml-basic/xhtml-basic11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="es" >
<html lang="es">
    <head>
        <title>Contenido</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link href="./style/formulario_style.css" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Calibri' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700,400italic' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <header>
            <div id="txt1">
                <h1 class="texto_titulo"><b>Contenido</b></h1>
            </div>
            <div id="txt2">
            	<?php
            		echo '<p id="texto2"><b>Sitio:'.$sitio.' Nodo:'.$nodo.'</b></p>';
                ?>
            </div>
        </header>
        <section id="Seccion_Central">
            <div id="botones">
                <div class="boton">
                    <div class="central">
                        <div id="btn1">
                            <ul>
                                <li><a href="http://proyecto.modulo2/">Regresar</a></li>
                            </ul> 
                        </div>
                    </div>
                </div>
            </div>
            <div id="formulario">
                <fieldset style="margin-top: 10px">
                    <legend class="TextoFormulario" style="color:#4c4c4c">Contenido del sitio</legend>
                    <p class="TextoFormulario" style="text-align: left; margin-top:10px;"><b>Fecha de publicación:</b></p>
                    <?php
                    	echo '<p class="TextoFormulario" style="text-align: left; margin-bottom: 15px;">'.$obj_nodo->{$nodo}->{'date'}.'</p>';
                    ?>
                    <p class="TextoFormulario" style="text-align: left; margin-top:10px;"><b>Lenguaje de la publicación:</b></p>
                    <?php
                    	echo '<p class="TextoFormulario" style="text-align: left; margin-bottom: 15px;">'.$obj_nodo->{$nodo}->{'lang'}.'</p>';
                    ?>
                    <p class="TextoFormulario" style="text-align: left; margin-top:10px;"><b>Título:</b></p>
                    <?php
                    	echo '<p class="TextoFormulario" style="text-align: left; margin-bottom: 15px;">'.$obj_nodo->{$nodo}->{'title'}.'</p>';
                    ?>
                    <p class="TextoFormulario" style="text-align: left; margin-top:10px;"><b>Imágen:</b></p>
                    <?php
                    	echo '<img src="http://back-end.com/site2/sites/site'.$sitio.'/files/styles/large/public/2016-03/'.$obj_img->{$nodo}->{'img_filename'}.'" style="margin-left:20px;">';
                    ?>
                    <p class="TextoFormulario" style="text-align: left; margin-top:10px;"><b>Contenido:</b></p>
                    <?php
                    	echo $obj_nodo->{$nodo}->{'contenido'};
                    ?>
                    <p class="TextoFormulario" style="text-align: left; margin-top:10px;"><b>Comentarios:</b></p>
                    <?php
                    	foreach ($obj_comment as $key => $value) {
                    		echo '<p class="TextoFormulario" style="text-align: left; margin-bottom: 15px;">Comentario'.$key.'</p>';
                    		echo $obj_comment->{$key}->{'contenido'};
                    	}
                    ?>
                    <p class="TextoFormulario" style="text-align: left; margin-top:10px;"><b>Agregar comentario:</b></p>

                    <?php
                    	echo '<form action="http://back-end.com/site'.$sitio.'/rest/comentar" method="POST">';
                    ?>
  						<textarea id="field" cols="50" name="comentario" rows="6" style="margin-left:20px; margin-top:20px; margin-bottom:20px;"></textarea>
  						<?php
  							echo '<input hidden name="nodo" value="'.$nodo.'"/>';
  						?>
  						<p><input type="submit" value="Comentar" style="margin-left:20px; margin-top:20px; margin-bottom:20px;"></p>
					</form>
                </fieldset>
            </div>
        </section>
    </body>
</html>
