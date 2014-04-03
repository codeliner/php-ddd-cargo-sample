<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
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
use CargoBackend\API\Exception\CargoNotFoundException;
use PhlyRestfully\Exception\CreationException;
use PhlyRestfully\Exception\DomainException;
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
        $this->listeners[] = $events->attach('fetch', array($this, 'onFetch'));
        $this->listeners[] = $events->attach('fetchAll', array($this, 'onFetchAll'));

        $sharedEvents = $events->getSharedManager();

        $sharedEvents->attach('PhlyRestfully\Plugin\HalLinks', 'getIdFromResource', array($this, 'onGetIdFromResource'));
    }

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
            $this->cargoFrom->get('finalDestination')->getValue()
        );

        $cargoRouting = new CargoRoutingDto();
        $cargoRouting->setTrackingId($trackingId);
        $cargoRouting->setOrigin($this->cargoFrom->get('origin')->getValue());
        $cargoRouting->setFinalDestination($this->cargoFrom->get('finalDestination')->getValue());

        return $cargoRouting;
    }

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

    public function onFetchAll(ResourceEvent $e)
    {
        return $this->bookingService->listAllCargos();
    }

    public function onGetIdFromResource(EventInterface $e)
    {
        $resource = $e->getParam('resource');

        if (isset($resource['tracking_id'])) {
            return $resource['tracking_id'];
        }

        return false;
    }

    //@TODO: Implement methods
}
 