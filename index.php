<?php
error_reporting(E_ALL ^ E_NOTICE);

@set_time_limit(900); //15min.

header('Content-type: text/html; charset=UTF-8');

//remplace GET et POST par les noms de variables
foreach ($_GET as $key => $value) $$key = $value;
foreach ($_POST as $key => $value) $$key = $value;

include_once "config.php";

//initialisation des variables de navigation pour la premiere utilisation
if(!isset($page))
    $page = "";
if(!isset($spage))
    $spage = "";

include $controller_file;

//include pour le fonctionnement de l'orm doctrine
include $crud_file;
?>

<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta name="description" content="<?php echo $metadescription; ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta http-equiv="Content-Language" content="fr" />
        <link href="<?php echo $styleGeneral_file; ?>" rel="stylesheet" type="text/css" media="screen,print" />
        <link href="<?php echo $styleMenu_file; ?>" rel="stylesheet" type="text/css" media="screen,print" />
    </head>
    
    <body>
        <?php
            include $header_file;
        ?>
        <div id="main_container">
        <?php
            include $body;
        ?>
        </div>
        <?php
            include $footer_file;
        ?>
    </body>
</html>
