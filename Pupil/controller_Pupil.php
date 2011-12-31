<?php


switch ($spage){
    case "index_pupil":
        $body = $index_pupil_file;
        $title = "Accueil élève";
        $metadescription = "Web Ecole - Accueil élève";
        break;
    
    case "show_absence":
        $body = $show_absence_file;
        $title = "Lister les absences";
        $metadescription = "Web Ecole - Listage des absences";
        break;
    
    case "show_lesson":
        $body = $show_lesson_file;
        $title = "Lister les cours";
        $metadescription = "Web Ecole - Listage des cours";
        break;
    
    default:
        $body = $index_pupil_file;
        $title = "Accueil élève";
        $metadescription = "Web Ecole - Accueil élève";
        break;

}

?>
