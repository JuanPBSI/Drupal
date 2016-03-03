<?php
    // Peticion Sitio2
    $server = 'http://back-end.com/site2/rest/list';
    $username = "jesus";
    $password = "chucho123.,";
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $server);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
    $json_sitio2=curl_exec($ch);
    curl_close($ch);

    $obj_sitio2 = json_decode($json_sitio2);

    // Conectarse a la base de datos
    $dbconn = pg_connect("host=localhost dbname=drupal8 user=drupaladmin password=ola123")
                or die('Error en la conexion: ' . pg_last_error());

    $contenido="";
    $contenido=$contenido.'<table border="1" cellpadding="1" cellspacing="1" style="width: 500px;">\n';
    $contenido=$contenido.'    <tbody>\n';
    $contenido=$contenido.'        <tr>\n';
    $contenido=$contenido.'            <td>\n';
    $contenido=$contenido.'<form action="/scripts/getSitio2.php" method="POST">\n';
    $contenido=$contenido.'<input type="submit" value="Actualizar Sitio 2" />\n';
    $contenido=$contenido.'</form>\n';    
    $contenido=$contenido.'            </td>\n';
    $contenido=$contenido.'        </tr>\n';
    $contenido=$contenido.'        <tr>\n';
    $contenido=$contenido.'            <td>\n';
    $contenido=$contenido.'            <ol>\n';
    foreach ($obj_sitio2 as $key => $value)
    {
        $contenido=$contenido.'                 <li><a href="http://get-data.com/?Sitio=2&Nodo='.$key.'">'.$obj_sitio2->{$key}->{'title'}.'</a></li>\n';
    }
    $contenido=$contenido.'            </ol>\n';
    $contenido=$contenido.'            </td>\n';
    $contenido=$contenido.'        </tr>\n';
    $contenido=$contenido.'    </tbody>\n';
    $contenido=$contenido.'</table>\n';
    $contenido=$contenido.'<p>&nbsp;</p>\n';

    $query = "UPDATE node__body SET body_value = E'$contenido' WHERE entity_id=5";
    $result = pg_query($dbconn, $query) or die('Error en la conexion: ' . pg_last_error());
    
    //Limpia cache
    $query="TRUNCATE cache_config;"."TRUNCATE cache_container;"."TRUNCATE cache_data;"."TRUNCATE cache_default;"."TRUNCATE cache_discovery;"."TRUNCATE cache_dynamic_page_cache;"."TRUNCATE cache_entity;"."TRUNCATE cache_menu;"."TRUNCATE cache_render;"."TRUNCATE cache_toolbar;";
    $result = pg_query($dbconn, $query) or die('Error en la conexion: ' . pg_last_error());
    pg_free_result($result);    // Free resultset
    pg_close($dbconn);        // Closing connection
    echo"listosss";
    header("location:../");
?>

