<?php
/*
 * This file is part of the prooph/cargo-sample2.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 07.12.2015 - 6:30 PM
 */
namespace Codeliner\CargoBackend\Http\Action;

use Codeliner\CargoBackend\Application\Booking\BookingService;
use Codeliner\CargoBackend\Application\Booking\Dto\LegDto;
use Codeliner\CargoBackend\Application\Booking\Dto\RouteCandidateDto;
use Codeliner\CargoBackend\Application\Exception\CargoNotFoundException;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class UpdateCargo
 *
 * @package Codeliner\CargoBackend\Application\Action
 */
final class UpdateCargo implements MiddlewareInterface
{
    /**
     * @var BookingService
     */
    private $bookingService;

    /**
     * UpdateCargo constructor.
     *
     * @param BookingService $bookingService
     */
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        if (null === $trackingId = $request->getAttribute('trackingId')) {
            return new EmptyResponse(404);
        }

        $cargoData = $request->getParsedBody();

        if (! isset($cargoData['legs']) || ! is_array($cargoData['legs'])) {
            throw new InvalidArgumentException("Missing legs for cargo");
        }

        $routeCandidate = new RouteCandidateDto();
        $routeCandidate->setLegs($this->toLegDtosFromData($cargoData['legs']));

        try {
            $this->bookingService->assignCargoToRoute($trackingId, $routeCandidate);

            $cargoRoutingDto = $this->bookingService->loadCargoForRouting($trackingId);

            return new JsonResponse($cargoRoutingDto->getArrayCopy());
        } catch (CargoNotFoundException $e) {
            return new EmptyResponse(404);
        }
    }

    /**
     * @param array $legs
     * @return LegDto[]
     */
    private function toLegDtosFromData(array $legs): array
    {
        $legDtos = array();

        foreach ($legs as $legData) {
            $legDto = new LegDto();

            $legDto->setLoadLocation($legData['load_location']);
            $legDto->setUnloadLocation($legData['unload_location']);
            $legDto->setLoadTime($legData['load_time']);
            $legDto->setUnloadTime($legData['unload_time']);

            $legDtos[] = $legDto;
        }

        return $legDtos;
    }
}
