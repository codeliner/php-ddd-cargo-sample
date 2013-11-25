<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Domain\Model\Cargo;

/**
 * CargoRepository to load and store Cargos
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface CargoRepositoryInterface
{
    /**
     * Finds a cargo using given id.
     * 
     * @param TrackingId $trackingId Id
     * @return Cargo if found, else {@code null}
     */
    public function findCargo(TrackingId $trackingId);
    
    /**
     * Finds all cargo.
     * 
     * @return Cargo[] all Cargo
     */
    public function findAll();
    
    /**
     * Saves given cargo.
     * 
     * @param Cargo $cargo Cargo to save
     */
    public function store(Cargo $cargo);
    
    /**
     * @return TrackingId A unique, generated tracking Id.
     */
    public function getNextTrackingId();
}
