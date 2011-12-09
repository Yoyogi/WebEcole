<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author Yoyogi
 */
class Admin extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName("administrateur");
        
        $this->hasColumn("id_administrateur", "integer", 11, array("primary" => true, "autoincrement" => true));
        $this->hasColumn("nom", "varchar", 45);
        $this->hasColumn("prenom", "varchar", 45);
        $this->hasColumn("date_naissance", "date");
        $this->hasColumn("rue", "varchar", 45);
        $this->hasColumn("cp", "int", 11);
        $this->hasColumn("ville", "varchar", 45);
        $this->hasColumn("email", "varchar", 45);
        $this->hasColumn("ulogin", "varchar", 45);
        $this->hasColumn("passwd", "varchar", 45);
    }
}

?>
