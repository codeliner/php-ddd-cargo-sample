<?php
/*
 * This file is part of the prooph/cargo-sample2.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 06.12.2015 - 8:18 PM
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Infrastructure\Persistence;

use Codeliner\CargoBackend\Model\Cargo\Cargo;
use Codeliner\CargoBackend\Model\Cargo\CargoRepositoryInterface;
use Codeliner\CargoBackend\Model\Cargo\TrackingId;
use Doctrine\ORM\EntityRepository;

final class DoctrineCargoRepository  extends EntityRepository implements CargoRepositoryInterface
{
    /**
     * Finds a cargo using given id.
     *
     * @param TrackingId $trackingId Id
     * @return Cargo if found, else null
     */
    public function get(TrackingId $trackingId)
    {
        return $this->find($trackingId);
    }

    /**
     * List all cargo.
     *
     * @return Cargo[] List of all Cargo
     */
    public function getAll(): array
    {
        return $this->findAll();
    }

    /**
     * Saves given cargo.
     *
     * @param Cargo $cargo Cargo to save
     */
    public function store(Cargo $cargo)
    {
        $this->getEntityManager()->persist($cargo);
        $this->getEntityManager()->flush($cargo);
    }

    /**
     * @return TrackingId A unique, generated tracking Id.
     */
    public function getNextTrackingId(): TrackingId
    {
        return TrackingId::generate();
    }
}
