<?php

/**
 * BaseEtudiantPromotion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_etudiant
 * @property integer $id_promo
 * @property Etudiant $Etudiant
 * @property Promotion $Promotion
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEtudiantPromotion extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('etudiant_promotion');
        $this->hasColumn('id_etudiant', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '11',
             ));
        $this->hasColumn('id_promo', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '11',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Etudiant', array(
             'local' => 'id_etudiant',
             'foreign' => 'id_etudiant'));

        $this->hasOne('Promotion', array(
             'local' => 'id_promo',
             'foreign' => 'id_promo'));
    }
}