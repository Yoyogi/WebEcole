<?php


switch ($spage){
    case "add_division":
        $body = $add_division_file;
        $title = "Ajouter une division";
        $metadescription = "Web Ecole - Ajout de divisions";
        break;
    
    case "add_lesson":
        $body = $add_lesson_file;
        $title = "Ajouter un cours";
        $metadescription = "Web Ecole - Ajout de cours";
        break;
    
    case "add_people":
        $body = $add_people_file;
        $title = "Ajouter une personne";
        $metadescription = "Web Ecole - Ajout de personnes";
        break;
    
    case "add_subject":
        $body = $add_subject_file;
        $title = "Ajouter une matière";
        $metadescription = "Web Ecole - Ajout de matières";
        break;
    
    case "index_admin":
        $body = $index_admin_file;
        $title = "Accueil administrateur";
        $metadescription = "Web Ecole - Accueil administrateur";
        break;
    
    case "manage_absence":
        $body = $manage_absence_file;
        $title = "Gérer une absence";
        $metadescription = "Web Ecole - Gestion d'absences";
        break;
    
    case "manage_division":
        $body = $manage_division_file;
        $title = "Gérer une division";
        $metadescription = "Web Ecole - Gestion de divisions";
        break;
    
    case "manage_lesson":
        $body = $manage_lesson_file_admin;
        $title = "Gérer un cours";
        $metadescription = "Web Ecole - Gestion des cours";
        break;
    
    case "manage_people":
        $body = $manage_people_file;
        $title = "Gérer une personne";
        $metadescription = "Web Ecole - Gestion de personnes";
        break;
    
    case "manage_subject":
        $body = $manage_subject_file;
        $title = "Gérer une matière";
        $metadescription = "Web Ecole - Gestion des matières";
        break;
    
    case "modify_division":
        $body = $modify_division_file;
        $title = "Modifier une classe";
        $metadescription = "Web Ecole - modification de classes";
        break;
    
    case "modify_lesson":
        $body = $modify_lesson_file;
        $title = "Modifier un cours";
        $metadescription = "Web Ecole - modification de cours";
        break;
    
    case "modify_people":
        $body = $modify_people_file;
        $title = "Modifier une personne";
        $metadescription = "Web Ecole - Modification de personnes";
        break;
    
    case "modify_subject":
        $body = $modify_subject_file;
        $title = "Modifier une matière";
        $metadescription = "Web Ecole - Modification de matières";
        break;
    
    
    
    default:
        $body = $index_admin_file;
        $title = "Accueil administrateur";
        $metadescription = "Web Ecole - Accueil administrateur";
        break;

}
?>
