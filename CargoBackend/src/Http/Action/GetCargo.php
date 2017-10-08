<?php
/*
 * This file is part of the prooph/cargo-sample2.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 07.12.2015 - 2:15 PM
 */
namespace Codeliner\CargoBackend\Http\Action;

use Codeliner\CargoBackend\Application\Booking\BookingService;
use Codeliner\CargoBackend\Application\Exception\CargoNotFoundException;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class GetCargo
 *
 * @package Codeliner\CargoBackend\Application\Action
 */
final class GetCargo implements MiddlewareInterface
{
    /**
     * @var BookingService
     */
    private $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        if (null === $trackingId = $request->getAttribute('trackingId')) {
            return new EmptyResponse(404);
        }

        try {
            $cargoRoutingDto = $this->bookingService->loadCargoForRouting($trackingId);

            return new JsonResponse($cargoRoutingDto->getArrayCopy());
        } catch (CargoNotFoundException $e) {
            return new EmptyResponse(404);
        }
    }
}
