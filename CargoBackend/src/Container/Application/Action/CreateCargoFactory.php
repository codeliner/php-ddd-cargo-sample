<?php
/*
 * This file is part of the prooph/cargo-sample2.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 06.12.2015 - 11:02 PM
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Container\Application\Action;

use Codeliner\CargoBackend\Application\Action\CreateCargo;
use Codeliner\CargoBackend\Application\Booking\BookingService;
use Interop\Container\ContainerInterface;

/**
 * Class CreateCargoFactory
 *
 * @package Codeliner\CargoBackend\Container\Application\Action
 */
final class CreateCargoFactory
{
    /**
     * @param ContainerInterface $container
     * @return CreateCargo
     */
    public function __invoke(ContainerInterface $container): CreateCargo
    {
        return new CreateCargo($container->get(BookingService::class));
    }
}
