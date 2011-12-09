<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Help
 *
 * @author Yoyogi
 */
class Help extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName("aide");
        
        $this->hasColumn("id_aide", "integer", 11, array("primary" => true, "autoincrement" => true));
        $this->hasColumn("page", "varchar", 45);
        $this->hasColumn("libelle", "varchar", 45);
    }
}

?>
