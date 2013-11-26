<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Service;

use Application\Domain\Model\Cargo;
use Application\Domain\Model\Voyage; 
/**
 *  BookingService
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class BookingService
{
    /**
     * The CargoRepository
     * 
     * @var Cargo\CargoRepositoryInterface 
     */
    protected $cargoRepository;    
    
    /**
     *
     * @var Voyage\VoyageRepositoryInterface 
     */
    protected $voyageRepository;
    
    /**
     *
     * @var Policy\OverbookingPolicyInterface 
     */
    protected $overbookingPolicy;
    
    public function bookNewCargo(Cargo\Cargo $cargo, Voyage\Voyage $voyage)
    {
        if (!$this->overbookingPolicy->isAllowed($cargo, $voyage)) {
            throw new Exception\RuntimeException(
                sprintf(
                    'Cargo [%s] can not be booked. Voyage [%s] has not enough capacity.',
                    $cargo->getTrackingId()->toString(),
                    $voyage->getVoyageNumber()->toString()
                )
            );
        }
        
        $voyage->bookCargo($cargo);
        
        $this->voyageRepository->store($voyage);
        $this->cargoRepository->store($cargo);
    }


    /**
     * Set the CargoRepository
     * 
     * @param Cargo\CargoRepositoryInterface $cargoRepository
     * @return void
     */
    public function setCargoRepository(Cargo\CargoRepositoryInterface $cargoRepository) 
    {
        $this->cargoRepository = $cargoRepository;
    }
    
    /**
     * Set the voyage repository
     * 
     * @param Voyage\VoyageRepositoryInterface $voyageRepository
     * @return void
     */
    public function setVoyageRepository(Voyage\VoyageRepositoryInterface $voyageRepository)
    {
        $this->voyageRepository = $voyageRepository;
    }
    
    /**
     * Set OverbookingPolicy
     * 
     * @param Policy\OverbookingPolicyInterface $overbookingPolicy
     * @return void
     */
    public function setOverbookingPolicy(Policy\OverbookingPolicyInterface $overbookingPolicy)
    {
        $this->overbookingPolicy = $overbookingPolicy;
    }
}
