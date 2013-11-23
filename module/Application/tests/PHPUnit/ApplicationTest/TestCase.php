<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApplicationTest;

use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Types\Type;
/**
 *  TestCase
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class TestCase extends PHPUnit_Framework_TestCase
{
    protected $entityManager;
    protected $schemaTool;
    
    /**
     *
     * @return EntityManager
     */
    public function getTestEntityManager()
    {
        if (null === $this->entityManager) {
            $conn = \Doctrine\DBAL\DriverManager::getConnection(array(
                'driver' => 'pdo_sqlite',
                'memory' => true
            ));

            $config = new \Doctrine\ORM\Configuration();

            $config->setAutoGenerateProxyClasses(true);
            $config->setProxyDir(\sys_get_temp_dir());
            $config->setProxyNamespace(get_class($this) . '\Entities');
            $config->setMetadataDriverImpl(
                new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(
                    new \Doctrine\Common\Annotations\IndexedReader(
                        new \Doctrine\Common\Annotations\AnnotationReader()
                    )
                )
            );

            $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
            $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
            
            $this->entityManager = \Doctrine\ORM\EntityManager::create(array(
                'driver' => 'pdo_sqlite',
                'memory' => true
            ), $config);
            
            //Add custom DDD types to map ValueObjects correctly
            if (!Type::hasType('trackingid')) {
                Type::addType('trackingid', 'Application\Infrastructure\Persistence\Doctrine\Type\TrackingId');
            } 
            
            if (!Type::hasType('uid')) {
                Type::addType('uid', 'Application\Infrastructure\Persistence\Doctrine\Type\UID');
            }
            
            if (!Type::hasType('voyagenumber')) {
                Type::addType('voyagenumber', 'Application\Infrastructure\Persistence\Doctrine\Type\VoyageNumber');
            }
        }
        
        
        return $this->entityManager;
    }

    public function createEntitySchema($entityNameOrNamespace, $pathToEntityDir = null)
    {
        if (!is_null($pathToEntityDir)) {
            $dir = opendir($pathToEntityDir);

            $entityNameOrNamespace = trim($entityNameOrNamespace, '\\');

            while($file = readdir($dir)) {
                if (0 !== strpos($file, '.')) {
                    $entityClass = $entityNameOrNamespace . '\\' . str_replace('.php', '', $file);
                    $this->createEntitySchema($entityClass);
                }
            }

            return;
        }

        if (null === $this->schemaTool) {
            $this->schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->getTestEntityManager());
        }
        $schema = $this->getTestEntityManager()->getClassMetadata($entityNameOrNamespace);
        $this->schemaTool->dropSchema(array($schema));
        $this->schemaTool->createSchema(array($schema));
    }
}
