<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Teacher
 *
 * @author Yoyogi
 */
class Teacher extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName("enseignant");
        
        $this->hasColumn("id_enseignant", "integer", 11, array("primary" => true, "autoincrement" => true));
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
    
    public function setUp() {
        $this->hasMany(
                'cours as lessons',
                array(
                    'local' => 'id_enseignant',
                    'foreign' => 'id_cours'
                )
            );
        
        $this->hasMany(
                'matiere as subjects',
                array(
                    'local' => 'id_enseignant',
                    'foreign' => 'id_matiere'
                )
            );
    }
}

?>
