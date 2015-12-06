<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 8/9/15 - 10:07 PM
 */
namespace Codeliner\CargoBackend\Container\Infrastructure;

use Codeliner\CargoBackend\Infrastructure\Persistence\Doctrine\Type\LegsDoctrineType;
use Codeliner\CargoBackend\Infrastructure\Persistence\Doctrine\Type\TrackingIdDoctrineType;
use Doctrine\DBAL\Types\Type;
use Interop\Container\ContainerInterface;

final class DoctrineEntityManagerFactory
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @return mixed
     */
    public function __invoke(ContainerInterface $container)
    {
        $appConfig = $container->get('config');

        if (! isset($appConfig['doctrine']['connection']['orm_default'])) {
            throw new \RuntimeException("Missing doctrine connection config for orm_default driver");
        }

        $config = new \Doctrine\ORM\Configuration();

        $config->setAutoGenerateProxyClasses(true);
        $config->setProxyDir('data/cache');
        $config->setProxyNamespace('Codeliner\CargoBackend\Doctrine\Entities');
        $config->setMetadataDriverImpl(
            new \Doctrine\ORM\Mapping\Driver\XmlDriver(
                array(
                    __DIR__ . '/../../Infrastructure/Persistence/Doctrine/ORM'
                )
            )
        );

        $config->setNamingStrategy(new \Doctrine\ORM\Mapping\UnderscoreNamingStrategy());

        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());

        $entityManager = \Doctrine\ORM\EntityManager::create($appConfig['doctrine']['connection']['orm_default'], $config);

        //Add custom DDD types to map ValueObjects correctly
        if (!Type::hasType('cargo_itinerary_legs')) {
            Type::addType('cargo_itinerary_legs', LegsDoctrineType::class);
        }

        if (!Type::hasType('cargo_tracking_id')) {
            Type::addType(TrackingIdDoctrineType::NAME, TrackingIdDoctrineType::class);
        }

        return $entityManager;
    }
}