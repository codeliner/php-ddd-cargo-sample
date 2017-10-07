<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CodelinerTest\CargoBackend;

use Codeliner\CargoBackend\Infrastructure\Persistence\Doctrine\Type\LegsDoctrineType;
use Codeliner\CargoBackend\Infrastructure\Persistence\Doctrine\Type\TrackingIdDoctrineType;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\Types\Type;
/**
 *  TestCase
 * 
 * @author Alexander Miertsch <contact@prooph.de>
 */
class TestCase extends PHPUnit_Framework_TestCase
{
    protected $entityManager;
    protected $schemaTool;
    
    /**
     *
     * @return EntityManager
     */
    public function getTestEntityManager(): EntityManager
    {
        if (null === $this->entityManager) {
            $conn = \Doctrine\DBAL\DriverManager::getConnection(array(
                'driver' => 'pdo_sqlite',
                'dbname' => ':memory:'
            ));

            $config = new \Doctrine\ORM\Configuration();

            $config->setAutoGenerateProxyClasses(true);
            $config->setProxyDir(\sys_get_temp_dir());
            $config->setProxyNamespace(get_class($this) . '\Entities');
            $config->setMetadataDriverImpl(
                new \Doctrine\ORM\Mapping\Driver\XmlDriver(
                    array(
                        __DIR__ . '/../src/Infrastructure/Persistence/Doctrine/ORM'
                    )
                )
            );
            
            $config->setNamingStrategy(new \Doctrine\ORM\Mapping\UnderscoreNamingStrategy());

            $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
            $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
            
            $this->entityManager = \Doctrine\ORM\EntityManager::create(array(
                'driver' => 'pdo_sqlite',
                'memory' => true
            ), $config);
            
            //Add custom DDD types to map ValueObjects correctly
            if (!Type::hasType('cargo_itinerary_legs')) {
                Type::addType('cargo_itinerary_legs', LegsDoctrineType::class);
            }

            if (!Type::hasType('cargo_tracking_id')) {
                Type::addType('cargo_tracking_id', TrackingIdDoctrineType::class);
            }
        }
        
        
        return $this->entityManager;
    }

    public function createEntitySchema($entityNameOrNamespace, $pathToEntityDir = null): void
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
