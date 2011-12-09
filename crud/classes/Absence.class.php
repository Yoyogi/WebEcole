<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Absence
 *
 * @author Yoyogi
 */
class Absence extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName("etudiant");
        
        $this->hasColumn("id_absence", "integer", 11, array("primary" => true, "autoincrement" => true));
        $this->hasColumn("motif", "varchar", 45);
        $this->hasColumn("id_etudiant", "integer", 11);
        $this->hasColumn("id_cours", "integer", 11);
    }
    
    public function setUp() {
        $this->hasOne(
                'etudiant as student',
                array(
                    'local' => 'id_absence',
                    'foreign' => 'id_etudiant'
                )
            );
        
        $this->hasOne(
                'cours as lesson',
                array(
                    'local' => 'id_absence',
                    'foreign' => 'id_cours'
                )
            );
    }
}

?>
