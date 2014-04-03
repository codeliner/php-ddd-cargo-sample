<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Controller;

use CargoBackend\API\Booking\BookingService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\CargoForm;

/**
 * MVC Controller for Cargo Management
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class BookingAppController extends AbstractActionController
{
    /**
     * @var BookingService
     */
    private $bookingService;

    /**
     * @var CargoForm
     */
    private $cargoForm;

    /**
     * @param BookingService $aBookingService
     * @param CargoForm $aCargoForm
     */
    public function __construct(BookingService $aBookingService, CargoForm $aCargoForm)
    {
        $this->bookingService = $aBookingService;
        $this->cargoForm      = $aCargoForm;
    }

    /**
     * Load booking app
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $locationDtos = $this->bookingService->listShippingLocations();

        $locations = array();

        foreach ($locationDtos as $locationDto) {
            $locations[] = array(
                'un_locode' => $locationDto->getUnLocode(),
                'name'      => $locationDto->getName()
            );
        }

        return new ViewModel(array('locations' => $locations, 'cargoForm' => $this->cargoForm));
    }
}
