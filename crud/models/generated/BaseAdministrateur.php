<?php

/**
 * BaseAdministrateur
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id_administrateur
 * @property string $nom
 * @property string $prenom
 * @property string $rue
 * @property integer $cp
 * @property string $ville
 * @property string $email
 * @property string $ulogin
 * @property string $passwd
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAdministrateur extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('administrateur');
        $this->hasColumn('id_administrateur', 'integer', 11, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '11',
             ));
        $this->hasColumn('nom', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '45',
             ));
        $this->hasColumn('prenom', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '45',
             ));
        $this->hasColumn('rue', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '45',
             ));
        $this->hasColumn('cp', 'integer', 11, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '11',
             ));
        $this->hasColumn('ville', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '45',
             ));
        $this->hasColumn('email', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '45',
             ));
        $this->hasColumn('ulogin', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '45',
             ));
        $this->hasColumn('passwd', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '45',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}