<?php

/**
 * BasePromotion
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_promo
 * @property string $libelle
 * @property Doctrine_Collection $Etudiants
 * @property Doctrine_Collection $Cours
 * @property Doctrine_Collection $EtudiantPromotion
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePromotion extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('promotion');
        $this->hasColumn('id_promo', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('libelle', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '45',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Etudiant as Etudiants', array(
             'refClass' => 'EtudiantPromotion',
             'local' => 'id_etudiant',
             'foreign' => 'id_etudiant'));

        $this->hasMany('Cours', array(
             'local' => 'id_promo',
             'foreign' => 'id_promo'));

        $this->hasMany('EtudiantPromotion', array(
             'local' => 'id_promotion',
             'foreign' => 'id_promotion'));
    }
}