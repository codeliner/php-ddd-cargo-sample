<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 8/13/15 - 12:16 AM
 */
namespace Codeliner\CargoBackend\API\Factory;


use Codeliner\CargoBackend\API\Action\GetLocations;
use Interop\Container\ContainerInterface;

final class GetLocationsFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new GetLocations($container->get('cargo.backend.booking_service'));
    }
} 