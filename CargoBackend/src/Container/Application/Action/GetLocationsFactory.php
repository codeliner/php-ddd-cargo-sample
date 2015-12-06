<?php
/*
 * This file is part of the prooph/cargo-sample2.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 06.12.2015 - 9:46 PM
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Container\Application\Action;

use Codeliner\CargoBackend\Application\Action\GetLocations;
use Codeliner\CargoBackend\Application\Booking\BookingService;
use Interop\Container\ContainerInterface;

/**
 * Class GetLocationsFactory
 *
 * @package Codeliner\CargoBackend\Container\Application\Action
 */
final class GetLocationsFactory
{
    /**
     * @param ContainerInterface $container
     * @return GetLocations
     */
    public function __invoke(ContainerInterface $container): GetLocations
    {
        return new GetLocations($container->get(BookingService::class));
    }
}