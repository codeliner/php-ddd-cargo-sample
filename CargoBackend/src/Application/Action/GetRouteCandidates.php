<?php
/*
 * This file is part of the prooph/cargo-sample2.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 06.12.2015 - 11:23 PM
 */
namespace Codeliner\CargoBackend\Application\Action;

use Codeliner\CargoBackend\Application\Booking\BookingService;
use Codeliner\CargoBackend\Application\Booking\Dto\RouteCandidateDto;
use Codeliner\CargoBackend\Model\Cargo\TrackingId;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class GetRouteCandidates
 *
 * @package Codeliner\CargoBackend\Application\Action
 */
final class GetRouteCandidates
{
    /**
     * @var BookingService
     */
    private $bookingService;

    /**
     * GetRouteCandidates constructor.
     *
     * @param BookingService $bookingService
     */
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        if (null === $trackingId = $request->getAttribute('trackingId')) {
            throw new \InvalidArgumentException('Missing tracking id');
        }

        return new JsonResponse([
            'routeCandidates' => array_map(function(RouteCandidateDto $routeCandidate){
                return $routeCandidate->getArrayCopy();
            }, $this->bookingService->requestPossibleRoutesForCargo($trackingId))
        ]);
    }
}
