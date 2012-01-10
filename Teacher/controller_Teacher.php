<?php

switch ($spage){
    case "index_teacher":
        $body = $index_teacher_file;
        $title = "Accueil professeur";
        $metadescription = "Web Ecole - Accueil professeur";
        break;
    
    case "manage_absence":
        $body = $manage_absence_file_teacher;
        $title = "Ajouter un cours";
        $metadescription = "Web Ecole - Ajout de cours";
        break;
    
    case "manage_exercice":
        $body = $manage_exercice_file;
        $title = "Gérer les exercices";
        $metadescription = "Web Ecole - Gestion des exercices";
        break;
    
    case "manage_lesson":
        $body = $manage_lesson_file_teacher;
        $title = "Gérer un cours";
        $metadescription = "Web Ecole - Gestion de cours";
        break;
    
    case "show_students":
        $body = $show_student_file;
        $title = "Lister les élèves";
        $metadescription = "Web Ecole - Listage des élèves";
        break;    
    
    
    default:
        $body = $index_teacher_file;
        $title = "Accueil professeur";
        $metadescription = "Web Ecole - Accueil professeur";
        break;

}
?>
