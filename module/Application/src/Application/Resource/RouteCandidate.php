<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 03.04.14 - 20:08
 */

namespace Application\Resource;
use CargoBackend\API\Booking\BookingServiceInterface;
use PhlyRestfully\ResourceEvent;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;

/**
 * Class RouteCandidate
 *
 * @package Application\Resource
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class RouteCandidate extends AbstractListenerAggregate
{
    /**
     * @var BookingServiceInterface
     */
    private $bookingService;

    /**
     * @param BookingServiceInterface $aBookingService
     */
    public function __construct(BookingServiceInterface $aBookingService)
    {
        $this->bookingService = $aBookingService;
    }

    /**
     * Attach one or more listeners
     *
     * Implementors may add an optional $priority argument; the EventManager
     * implementation will pass this to the aggregate.
     *
     * @param EventManagerInterface $events
     *
     * @return void
     */
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach('fetchAll', array($this, 'onFetchAll'));
    }

    /**
     * @param ResourceEvent $e
     * @return \CargoBackend\API\Booking\Dto\RouteCandidateDto[]
     */
    public function onFetchAll(ResourceEvent $e)
    {
        $trackingId = $e->getRouteMatch()->getParam('tracking_id');

        return $this->bookingService->requestPossibleRoutesForCargo($trackingId);
    }
}
 