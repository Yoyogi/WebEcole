<?php

switch ($spage) {
    case "auth":
        $body = $index_file;
        $title = "Connexion Web Ecole";
        $metadescription = "Web Ecole - Connexion";
        break;
    
    case "log_forward":
        $body = $log_forwarding_file;
        $title = "Connection Web Ecole en cours...";
        $metadescription = "Web Ecole - Connexion";
        break;
    
    case "deconnexion":
        $body = $deconnexion_file;
        $title = "Déconnexion";
        $metadescription = "Web Ecole - Deconnexion";
        break;
    
    default:
        $body = $index_file;
        $title = "Connexion Web Ecole";
        $metadescription = "Web Ecole - Connexion";
        break;
}
?>
