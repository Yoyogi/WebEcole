<?php
switch($page) {
    case "auth":
        $body = $index_file;
        $title = "Connexion Web Ecole";
        $metadescription = "Web Ecole - Connexion";
        break;
    
    case "log_forward":
        $body = $log_forwarding_file;
        $title = "Connexion Web Ecole en cours ....";
        $metadescription = "Web Ecole - Connexion";
        break;
    
    case "add_eleve":
        $body = $add_eleve;
        $title = "Ajout d'un eleve";
        $metadescription = "Ajout d'un eleve - en cours";
        
    case "gest_personne":
        $body = $gest_personne_file;
        $title = "Gestion des personnes";
        $metadescription = "Web Ecole - Gestion des personnes";
        break;
    
    case "logged_accueil":
        $body = $logged_accueil;
        $title = "Ajouter une personne";
        $metadescription = "Web Ecole - Ajout de personnes";
        break;
    
    default:
        $body = $index_file;
        $title = "Connexion Web Ecole";
        $metadescription = "Web Ecole - Connexion";
        break;
}
?>
