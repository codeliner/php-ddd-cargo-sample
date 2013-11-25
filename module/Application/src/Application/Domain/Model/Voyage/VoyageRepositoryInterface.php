<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Domain\Model\Voyage;

/**
 * VoyageRepositoryInterface
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface VoyageRepositoryInterface
{
    /**
     * Find Voyage by number
     * 
     * @param VoyageNumber $voyageNumber
     * @return Voyage
     */
    public function findVoyage(VoyageNumber $voyageNumber);
    
    /**
     * List all Voyages
     * 
     * @return Voyage[]
     */
    public function findAll();
    
    /**
     * Saves given Voyage
     * 
     * @param Voyage $voyage
     * @return void
     */
    public function store(Voyage $voyage);
}
