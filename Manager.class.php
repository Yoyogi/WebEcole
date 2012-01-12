<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Manage
 *
 * @author Midgard
 */
class Manager {
    public static $ADMIN = 0;
    public static $TEACHER = 1;
    public static $STUDENT = 2;
    
    public function getStatus($str) {
        if ($str == "Admin") {
            return ManagePeople::$ADMIN;
        }
        else if ($str == "Enseignant") {
            return ManagePeople::$TEACHER;
        }
        else {
            return ManagePeople::$STUDENT;
        }
    } 
}

?>
