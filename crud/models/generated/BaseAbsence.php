<?php

/**
 * BaseAbsence
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_absence
 * @property string $motif
 * @property integer $id_etudiant
 * @property integer $id_cours
 * @property Etudiant $Etudiant
 * @property Cours $Cours
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAbsence extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('absence');
        $this->hasColumn('id_absence', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('motif', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '45',
             ));
        $this->hasColumn('id_etudiant', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('id_cours', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Etudiant', array(
             'local' => 'id_etudiant',
             'foreign' => 'id_etudiant'));

        $this->hasOne('Cours', array(
             'local' => 'id_cours',
             'foreign' => 'id_cours'));
    }
}