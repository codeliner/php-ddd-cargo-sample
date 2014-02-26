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
    public function get(TrackingId $trackingId);
    
    /**
     * List all cargo.
     * 
     * @return Cargo[] List of all Cargo
     */
    public function getAll();
    
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
