<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 8/13/15 - 12:11 AM
 */
namespace Codeliner\CargoBackend\Http\Action;

use Codeliner\CargoBackend\Application\Booking\BookingService;
use Codeliner\CargoBackend\Application\Booking\Dto\LocationDto;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class GetLocations
 * Get Locations API Endpoint
 *
 * @package Codeliner\ApiGateway\Action
 */
final class GetLocations implements MiddlewareInterface
{
    /**
     * @var BookingService
     */
    private $bookingService;

    /**
     * GetLocations constructor.
     *
     * @param BookingService $bookingService
     */
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        return new JsonResponse(['locations' => array_map(function(LocationDto $locationDto) {
            return [
                'name' => $locationDto->getName(),
                'unLocode' => $locationDto->getUnLocode()
            ];
        }, $this->bookingService->listShippingLocations())]);        
    }
}
