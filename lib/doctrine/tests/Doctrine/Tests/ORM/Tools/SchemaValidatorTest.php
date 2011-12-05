<?php

namespace Doctrine\Tests\ORM\Tools;

use Doctrine\ORM\Tools\SchemaValidator;

require_once __DIR__ . '/../../TestInit.php';

class SchemaValidatorTest extends \Doctrine\Tests\OrmTestCase
{
    /**
     * @var EntityManager
     */
    private $em = null;

    /**
     * @var SchemaValidator
     */
    private $validator = null;

    public function setUp()
    {
        $this->em = $this->_getTestEntityManager();
        $this->validator = new SchemaValidator($this->em);
    }

    public function testCmsModelSet()
    {
        $this->em->getConfiguration()->getMetadataDriverImpl()->addPaths(array(
            __DIR__ . "/../../Models/CMS"
        ));
        $this->validator->validateMapping();
    }

    public function testCompanyModelSet()
    {
        $this->em->getConfiguration()->getMetadataDriverImpl()->addPaths(array(
            __DIR__ . "/../../Models/Company"
        ));
        $this->validator->validateMapping();
    }

    public function testECommerceModelSet()
    {
        $this->em->getConfiguration()->getMetadataDriverImpl()->addPaths(array(
            __DIR__ . "/../../Models/ECommerce"
        ));
        $this->validator->validateMapping();
    }

    public function testForumModelSet()
    {
        $this->em->getConfiguration()->getMetadataDriverImpl()->addPaths(array(
            __DIR__ . "/../../Models/Forum"
        ));
        $this->validator->validateMapping();
    }

    public function testNavigationModelSet()
    {
        $this->em->getConfiguration()->getMetadataDriverImpl()->addPaths(array(
            __DIR__ . "/../../Models/Navigation"
        ));
        $this->validator->validateMapping();
    }

    public function testRoutingModelSet()
    {
        $this->em->getConfiguration()->getMetadataDriverImpl()->addPaths(array(
            __DIR__ . "/../../Models/Routing"
        ));
        $this->validator->validateMapping();
    }

    /**
     * @group DDC-1439
     */
    public function testInvalidManyToManyJoinColumnSchema()
    {
        $class1 = $this->em->getClassMetadata(__NAMESPACE__ . '\InvalidEntity1');
        $class2 = $this->em->getClassMetadata(__NAMESPACE__ . '\InvalidEntity2');

        $ce = $this->validator->validateClass($class1);

        $this->assertEquals(
            array(
                "The inverse join columns of the many-to-many table 'Entity1Entity2' have to contain to ALL identifier columns of the target entity 'Doctrine\Tests\ORM\Tools\InvalidEntity2', however 'key4' are missing.",
                "The join columns of the many-to-many table 'Entity1Entity2' have to contain to ALL identifier columns of the source entity 'Doctrine\Tests\ORM\Tools\InvalidEntity1', however 'key2' are missing."
            ),
            $ce
        );
    }

    /**
     * @group DDC-1439
     */
    public function testInvalidToOneJoinColumnSchema()
    {
        $class1 = $this->em->getClassMetadata(__NAMESPACE__ . '\InvalidEntity1');
        $class2 = $this->em->getClassMetadata(__NAMESPACE__ . '\InvalidEntity2');

        $ce = $this->validator->validateClass($class2);

        $this->assertEquals(
            array(
                "The referenced column name 'id' does not have a corresponding field with this column name on the class 'Doctrine\Tests\ORM\Tools\InvalidEntity1'.",
                "The join columns of the association 'assoc' have to match to ALL identifier columns of the source entity 'Doctrine\Tests\ORM\Tools\InvalidEntity2', however 'key3, key4' are missing."
            ),
            $ce
        );
    }
}

/**
 * @Entity
 */
class InvalidEntity1
{
    /**
     * @Id @Column
     */
    protected $key1;
    /**
     * @Id @Column
     */
    protected $key2;
    /**
     * @ManyToMany (targetEntity="InvalidEntity2")
     * @JoinTable (name="Entity1Entity2",
     *      joinColumns={@JoinColumn(name="key1", referencedColumnName="key1")},
     *      inverseJoinColumns={@JoinColumn(name="key3", referencedColumnName="key3")}
     *      )
     */
    protected $entity2;
}

/**
 * @Entity
 */
class InvalidEntity2
{
    /**
     * @Id @Column
     * @GeneratedValue(strategy="AUTO")
     */
    protected $key3;

    /**
     * @Id @Column
     * @GeneratedValue(strategy="AUTO")
     */
    protected $key4;

    /**
     * @ManyToOne(targetEntity="InvalidEntity1")
     */
    protected $assoc;
}