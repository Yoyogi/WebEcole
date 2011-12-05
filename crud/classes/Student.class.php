<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Student
 *
 * @author Yoyogi
 */
class Student extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName("etudiant");
        
        $this->hasColumn("id_etudiant", "integer", 11, array("primary" => true, "autoincrement" => true));
        $this->hasColumn("nom", "varchar", 45);
        $this->hasColumn("prenom", "varchar", 45);
        $this->hasColumn("date_naissance", "date");
        $this->hasColumn("rue", "varchar", 45);
        $this->hasColumn("cp", "int", 11);
        $this->hasColumn("ville", "varchar", 45);
        $this->hasColumn("email", "varchar", 45);
        $this->hasColumn("ulogin", "varchar", 45);
        $this->hasColumn("passwd", "varchar", 45);
        $this->hasColumn("photo", "varchar", 250);
        
        $this->hasColumn("id_promo", "integer", 11);
        $this->hasColumn("id_absence", "integer", 11);
    }
    
    public function setUp() {
        $this->hasMany(
                'promotion as promotions',
                array(
                    'local' => 'id_etudiant',
                    'foreign' => 'id_promo'
                )
            );
        
        $this->hasMany(
                'absence',
                array(
                    'local' => 'id_etudiant',
                    'foreign' => 'id_absence'
                )
            );
    }
}

?>
