<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 30.03.14 - 00:10
 */

namespace Application\Resource;

use Application\Form\CargoForm;
use CargoBackend\API\Booking\BookingServiceInterface;
use CargoBackend\API\Booking\Dto\CargoRoutingDto;
use CargoBackend\API\Booking\Dto\LegDto;
use CargoBackend\API\Booking\Dto\RouteCandidateDto;
use CargoBackend\API\Exception\CargoNotFoundException;
use PhlyRestfully\Exception\CreationException;
use PhlyRestfully\Exception\DomainException;
use PhlyRestfully\Exception\UpdateException;
use PhlyRestfully\ResourceEvent;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;

/**
 * Class CargoRouting
 *
 * @package Application\Resource
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoRouting extends AbstractListenerAggregate
{
    /**
     * @var BookingServiceInterface
     */
    private $bookingService;

    /**
     * @var CargoForm
     */
    private $cargoFrom;

    /**
     * @param BookingServiceInterface $aBookingService
     * @param CargoForm $aCargoForm
     */
    public function __construct(BookingServiceInterface $aBookingService, CargoForm $aCargoForm)
    {
        $this->bookingService = $aBookingService;
        $this->cargoFrom      = $aCargoForm;
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
        $this->listeners[] = $events->attach('create', array($this, 'onCreate'));
        $this->listeners[] = $events->attach('update', array($this, 'onUpdate'));
        $this->listeners[] = $events->attach('fetch', array($this, 'onFetch'));
        $this->listeners[] = $events->attach('fetchAll', array($this, 'onFetchAll'));

        $sharedEvents = $events->getSharedManager();

        $sharedEvents->attach('PhlyRestfully\Plugin\HalLinks', 'getIdFromResource', array($this, 'onGetIdFromResource'));
    }

    /**
     * @param ResourceEvent $e
     * @return CargoRoutingDto
     * @throws \PhlyRestfully\Exception\CreationException
     */
    public function onCreate(ResourceEvent $e)
    {
        $data = $e->getParam('data');

        $this->cargoFrom->setData((array)$data);

        if (! $this->cargoFrom->isValid()) {
            $creationException = new CreationException("Provided Cargo data is invalid.");

            $creationException->setAdditionalDetails(array('errors' => $this->cargoFrom->getMessages()));

            throw $creationException;
        }

        $trackingId = $this->bookingService->bookNewCargo(
            $this->cargoFrom->get('origin')->getValue(),
            $this->cargoFrom->get('final_destination')->getValue()
        );

        $cargoRouting = new CargoRoutingDto();
        $cargoRouting->setTrackingId($trackingId);
        $cargoRouting->setOrigin($this->cargoFrom->get('origin')->getValue());
        $cargoRouting->setFinalDestination($this->cargoFrom->get('final_destination')->getValue());

        return $cargoRouting;
    }

    /**
     * @param ResourceEvent $e
     * @return CargoRoutingDto
     * @throws \PhlyRestfully\Exception\DomainException
     */
    public function onFetch(ResourceEvent $e)
    {
        $trackingId = $e->getRouteMatch()->getParam('tracking_id');

        try {
            $cargoRouting = $this->bookingService->loadCargoForRouting($trackingId);
        } catch (CargoNotFoundException $ex) {
            throw new DomainException('CargoRouting can not be found', 404);
        }

        return $cargoRouting;
    }

    /**
     * @param ResourceEvent $e
     * @return \CargoBackend\API\Booking\Dto\CargoRoutingDto[]
     */
    public function onFetchAll(ResourceEvent $e)
    {
        return $this->bookingService->listAllCargos();
    }

    /**
     * @param ResourceEvent $e
     * @return \CargoBackend\API\Booking\Dto\CargoRoutingDto
     * @throws \PhlyRestfully\Exception\UpdateException
     */
    public function onUpdate(ResourceEvent $e)
    {
        $trackingId = $e->getRouteMatch()->getParam('tracking_id');

        $data = $e->getParam('data');

        if (! isset($data->legs)) {
            throw new UpdateException("Legs missing in CargoRouting payload", 400);
        }

        $routeCandidate = new RouteCandidateDto();

        $routeCandidate->setLegs($this->toLegDtosFromData($data->legs));

        $this->bookingService->assignCargoToRoute($trackingId, $routeCandidate);

        return $this->bookingService->loadCargoForRouting($trackingId);
    }

    /**
     * @param EventInterface $e
     * @return bool|string
     */
    public function onGetIdFromResource(EventInterface $e)
    {
        $resource = $e->getParam('resource');

        if (isset($resource['tracking_id'])) {
            return $resource['tracking_id'];
        }

        return false;
    }

    /**
     * @param array $legs
     * @return LegDto[]
     */
    private function toLegDtosFromData(array $legs)
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
 