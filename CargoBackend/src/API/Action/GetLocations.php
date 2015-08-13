<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 8/13/15 - 12:11 AM
 */
namespace Codeliner\CargoBackend\API\Action;

use Codeliner\CargoBackend\API\Booking\BookingServiceInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class GetLocations
{
    /**
     * @var BookingServiceInterface
     */
    private $bookingService;

    /**
     * @param BookingServiceInterface $bookingService
     */
    public function __construct(BookingServiceInterface $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $locations = $this->bookingService->listShippingLocations();

        $response->getBody()->write(json_encode(['locations' => $locations]));

        if ($next) {
            $next($request, $response);
        }
    }
} 