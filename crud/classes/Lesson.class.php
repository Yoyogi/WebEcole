<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lesson
 *
 * @author Yoyogi
 */
class Lesson extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName("cours");
        
        $this->hasColumn("id_cours", "integer", 11, array("primary" => true, "autoincrement" => true));
        $this->hasColumn("date_cours", "varchar", 45);
        $this->hasColumn("duree", "varchar", 45);
        $this->hasColumn("descript", "varchar", 45);
        
        $this->hasColumn("id_promo", "integer", 11);
        $this->hasColumn("id_enseignant", "integer", 11);
        $this->hasColumn("id_matiere", "integer", 11);
    }
    
    public function setUp() {
        $this->hasOne(
                'promotion',
                array(
                    'local' => 'id_cours',
                    'foreign' => 'id_promo'
                )
            );
        
        $this->hasOne(
                'matiere as subject',
                array(
                    'local' => 'id_cours',
                    'foreign' => 'id_matiere'
                )
            );
        
        $this->hasOne(
                'enseignant as teacher',
                array(
                    'local' => 'id_cours',
                    'foreign' => 'id_enseignant'
                )
            );
        
        $this->hasMany(
                'absence',
                array(
                    'local' => 'id_cours',
                    'foreign' => 'id_absence'
                )
            );
    }
}

?>
