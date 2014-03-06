<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 01.03.14 - 22:35
 */

namespace Application\Service;

use Application\Domain\Model\Cargo\Itinerary;
use Application\Domain\Model\Cargo\Leg;
use Application\Domain\Model\Cargo\RouteSpecification;
use Zend\Cache\Storage\StorageInterface;

/**
 * Class RoutingService
 *
 * The RoutingService takes a RouteSpecification, that describes the start location and the end location of a cargo
 * and fetches compatible routes that are described by Itineraries.
 *
 * @package Application\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class RoutingService 
{
    /**
     * @var array
     */
    private $routes = array();

    /**
     * @var StorageInterface
     */
    private $cache;

    public function __construct(array $aRouteList, StorageInterface $cache)
    {
        $this->routes = $aRouteList;
        $this->cache  = $cache;
    }

    /**
     * @param RouteSpecification $routeSpecification
     * @return Itinerary[]
     */
    public function fetchRoutesForSpecification(RouteSpecification $routeSpecification)
    {
        $cacheKey = 'itinerary_' . $routeSpecification->origin() . '_' . $routeSpecification->destination();

        $itineraries = $this->cache->getItem($cacheKey, $success);

        if (!$success) {
            $routes = \array_filter($this->routes, function($route) use ($routeSpecification) {
                return $route['origin'] === $routeSpecification->origin() && $route['destination'] === $routeSpecification->destination();
            });

            $itineraries = array();

            foreach($routes as $route) {
                $itineraries[] = $this->routeToItinerary($route);
            }

            $this->cache->setItem($cacheKey, $itineraries);
        }

        return $itineraries;
    }

    /**
     * @param array $route
     * @return Itinerary
     */
    private function routeToItinerary(array $route)
    {
        $legs = array();

        $loadDay = \rand(1,4);

        $loadTimestamp = strtotime("+$loadDay day");

        $loadTime = new \DateTime();
        $loadTime->setTimestamp($loadTimestamp);

        $elapsedDays = 0;

        $currentLocation = $route['origin'];
        $currentTime = $loadTime;

        if (!empty($route['stops'])) {
            foreach($route['stops'] as $unLocode => $duration) {
                $elapsedDays += $duration;

                $durationInterval = new \DateInterval('P' . $duration . 'DT' . \rand(1, 12) . 'H' . \rand(1, 60) . 'M');

                $currentTime->add(new \DateInterval('P1DT' . \rand(1, 12) . 'H' . \rand(1, 60) . 'M'));

                $loadTime = clone $currentTime;

                $currentTime->add($durationInterval);

                $unloadTime = clone $currentTime;

                $legs[] = new Leg($currentLocation, $unLocode, $loadTime, $unloadTime);

                $currentLocation = $unLocode;
            }
        }

        $destinationDuration = $route['duration'] - $elapsedDays;
        $durationInterval = new \DateInterval('P' . $destinationDuration . 'DT' . \rand(1, 12) . 'H' . \rand(1, 60) . 'M');

        $currentTime->add(new \DateInterval('P1DT' . \rand(1, 12) . 'H' . \rand(1, 60) . 'M'));

        $loadTime = clone $currentTime;

        $currentTime->add($durationInterval);

        $unloadTime = clone $currentTime;

        $legs[] = new Leg($currentLocation, $route['destination'], $loadTime, $unloadTime);

        return new Itinerary($legs);
    }
} 