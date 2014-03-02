<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Infrastructure\Persistence\Doctrine;

use Application\Domain\Model\Cargo\CargoRepositoryInterface;
use Application\Domain\Model\Cargo\Cargo;
use Application\Domain\Model\Cargo\TrackingId;
use Doctrine\ORM\EntityRepository;
use Rhumsaa\Uuid\Uuid;

/**
 *  CargoRepositoryDoctrine
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoRepositoryDoctrine extends EntityRepository implements CargoRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function get(TrackingId $trackingId)
    {
        return $this->find($trackingId->toString());
    }

    /**
     * List all cargo.
     *
     * @return Cargo[] List of all Cargos
     */
    public function getAll()
    {
        return $this->findAll();
    }
    
    /**
     * {@inheritDoc}
     */
    public function store(Cargo $cargo)
    {
        $this->getEntityManager()->persist($cargo);
        $this->getEntityManager()->flush($cargo);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getNextTrackingId()
    {
        return new TrackingId(Uuid::uuid4());
    }
}
