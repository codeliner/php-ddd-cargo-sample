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
namespace Codeliner\CargoBackend\Application\Action;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class GetLocations
 * Get Locations API Endpoint
 *
 * @package Codeliner\ApiGateway\Action
 */
final class GetLocations
{


    /**
     * @param QueryBus $queryBus
     */
    public function __construct(QueryBus $queryBus)
    {
        $this->locationsQueryBus = $queryBus;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return JsonResponse
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $promise = $this->locationsQueryBus->dispatch(new BackendQuery('Codeliner\LocationsBackend\API\Query\GetLocations'));

        $locations = null;

        \React\Promise\resolve($promise)->done(function($result) use (&$locations) {
            $locations = json_decode($result, true);
        });

        return new JsonResponse(['locations' => $locations]);
    }
}
