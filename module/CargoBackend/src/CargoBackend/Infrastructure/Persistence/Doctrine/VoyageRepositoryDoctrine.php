<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CargoBackend\Infrastructure\Persistence\Doctrine;

use CargoBackend\Model\Voyage;
use Doctrine\ORM\EntityRepository;
/**
 * Voyage Repository
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class VoyageRepositoryDoctrine extends EntityRepository implements Voyage\VoyageRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function get(Voyage\VoyageNumber $voyageNumber)
    {
        return $this->find($voyageNumber);
    }

    /**
     * {@inheritDoc}
     */
    public function getAll()
    {
        return $this->findAll();
    }

    /**
     * {@inheritDoc}
     */
    public function store(Voyage\Voyage $voyage)
    {
        $this->getEntityManager()->persist($voyage);
        $this->getEntityManager()->flush($voyage);
    }
}
