<?php
/*
 * This file is part of the prooph/cargo-sample2.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 07.12.2015 - 8:39 PM
 */
namespace Codeliner\CargoBackend\Http\Action;

use Codeliner\CargoBackend\Application\Booking\BookingService;
use Codeliner\CargoBackend\Application\Booking\Dto\CargoRoutingDto;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class GetCargos
 *
 * @package Codeliner\CargoBackend\Application\Action
 */
final class GetCargos implements MiddlewareInterface
{
    /**
     * @var BookingService
     */
    private $bookingService;

    /**
     * GetCargos constructor.
     * @param BookingService $bookingService
     */
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        return new JsonResponse(['cargos' => array_map(function(CargoRoutingDto $cargoRoutingDto) {
            return $cargoRoutingDto->getArrayCopy();
        }, $this->bookingService->listAllCargos() )]);
    }
}
