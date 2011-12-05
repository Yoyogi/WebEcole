<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Promotion
 *
 * @author Yoyogi
 */
class Promotion extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName("etudiant");
        
        $this->hasColumn("id_promo", "integer", 11, array("primary" => true, "autoincrement" => true));
        $this->hasColumn("libelle", "varchar", 45);
        $this->hasColumn("id_etudiant", "integer", 11);
        $this->hasColumn("id_cours", "integer", 11);
    }
    
    public function setUp() {
        $this->hasMany(
                'etudiant as students',
                array(
                    'local' => 'id_promo',
                    'foreign' => 'id_etudiant'
                )
            );
        
        $this->hasMany(
                'cours as lessons',
                array(
                    'local' => 'id_promo',
                    'foreign' => 'id_cours'
                )
            );
    }
}

?>
