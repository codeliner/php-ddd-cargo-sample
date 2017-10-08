<?php
/*
 * This file is part of the prooph/cargo-sample2.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 06.12.2015 - 11:13 PM
 */
namespace Codeliner\CargoBackend\Infrastructure\Container\Application\Action;

use Assert\Assertion;
use Codeliner\CargoBackend\Application\Booking\BookingService;
use Psr\Container\ContainerInterface;

/**
 * Class BookingActionFactory
 *
 * @package Codeliner\CargoBackend\Container\Application\Action
 */
final class BookingActionFactory
{
    public function __invoke(ContainerInterface $container, $requestedService)
    {
        Assertion::classExists($requestedService);

        return new $requestedService($container->get(BookingService::class));
    }
}
