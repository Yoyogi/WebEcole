<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Subject
 *
 * @author Yoyogi
 */
class Subject extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName("matiere");
        
        $this->hasColumn("id_matiere", "integer", 11, array("primary" => true, "autoincrement" => true));
        $this->hasColumn("libelle", "varchar", 45);
    }
    
    public function setUp() {
        $this->hasMany(
                'cours as lessons',
                array(
                    'local' => 'id_matiere',
                    'foreign' => 'id_cours'
                )
            );
        
        $this->hasMany(
                'enseignant as teacher',
                array(
                    'local' => 'id_matiere',
                    'foreign' => 'id_enseignant'
                )
            );
    }
}

?>
