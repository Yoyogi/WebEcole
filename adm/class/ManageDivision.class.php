<?php

require_once $crud_file;
require_once $manager;

class ManageDivision {
    public static $instance = NULL;
    private $header;
    
    static public function getInstance() {
        if (ManageDivision::$instance == NULL) {
            ManageDivision::$instance = new ManageDivision();
        }
        return ManageDivision::$instance;
    }
    
    function ManageDivision() {
        $this->header = array('id_promo' => 'Identifiant', 'libelle' => 'Libelle');
    }
    
    public function getDivision() {
        try {
            $crud = Crud::getInstance();
            $promotions = $crud->getPromotions();
            $index = 0;

            $array = array();
            foreach ($promotions as $promotion) {            
                $array[$index] = array();
                $array[$index]['id'] = $promotion->id_promo;
                $array[$index]['libelle'] = $promotion->libelle;
                $index++;
            }

            return $array;
        }
        catch (Exception $e) {
            throw $e;
        }
    }
    
    public function getHeader() {
        return $this->header;
    }
    
    public function deleteDivision($id) {
        try {
            $crud = Crud::getInstance();
            $crud->deletePromotion($id);
        }
        catch (Exception $e) {
            throw $e;
        }
    }
}

?>
