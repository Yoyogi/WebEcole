<?php
switch($page) {
    case "auth";
        include $controller_auth_file;
        break;
    
    case "adm";
        include $controller_adm_file;
        break;
    
    case "teacher";
        include $controller_teacher_file;
        break;
    
    case "pupil";
        include $controller_pupil_file;
        break;
}
?>
