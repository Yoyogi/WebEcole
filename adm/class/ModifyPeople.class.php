<?php

require_once $manager;

class ModifyPeople extends Manager {
    public static $instance = NULL;
    
    static public function getInstance() {
        if (ManagePeople::$instance == NULL) {
            ManagePeople::$instance = new ManagePeople();
        }
        return ManagePeople::$instance;
    }
    
    function ModifyPeople() {
        
    }
    
    function getPeopleByID($type, $id) {
        
    }
    
    function updatePeople() {
        
    }
}

?>
