<?php
switch($page) {
    case "auth":
        $body = $index_file;
        $title = "Connexion Web Ecole";
        $metadescription = "Web Ecole - Connexion";
        break;
    
    case "log_forward":
        $body = $log_forwarding_file;
        $title = "Connexion Web Ecole";
        $metadescription = "Web Ecole - Connexion";
        break;
    
    default:
        $body = $index_file;
        $title = "Connexion Web Ecole";
        $metadescription = "Web Ecole - Connexion";
        break;
}
?>
