<?php
/*
 * This file is part of the prooph/cargo-sample2.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 06.12.2015 - 10:35 PM
 */
namespace Codeliner\CargoBackend\Application\Action;

use Assert\Assertion;
use Codeliner\CargoBackend\Application\Booking\BookingService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class CreateCargo
 *
 * @package Codeliner\CargoBackend\Application\Action
 */
final class CreateCargo
{
    /**
     * @var BookingService
     */
    private $bookingService;

    /**
     * CreateCargo constructor.
     *
     * @param BookingService $bookingService
     */
    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $data = $request->getParsedBody();

        Assertion::keyExists($data, 'origin');
        Assertion::keyExists($data, 'destination');

        $trackingId = $this->bookingService->bookNewCargo($data['origin'], $data['destination']);

        return new JsonResponse(['trackingId' => $trackingId]);
    }
}
