<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 19:57
 */

namespace CodelinerTest\CargoBackend\Mock;

use Codeliner\GraphTraversalBackend\Dto\EdgeDto;
use Codeliner\GraphTraversalBackend\Dto\TransitPathDto;
use Codeliner\GraphTraversalBackend\GraphTraversalServiceInterface;

/**
 * Class GraphTraversalServiceMock
 *
 * @package CodelinerTest\CargoBackend\Domain\Mock
 * @author Alexander Miertsch <contact@prooph.de>
 */
class GraphTraversalServiceMock implements GraphTraversalServiceInterface
{
    /**
     * @param string $fromUnLocode
     * @param string $toUnLocode
     * @return TransitPathDto[]
     */
    public function findShortestPath($fromUnLocode, $toUnLocode): array
    {
        $transitPath = new TransitPathDto();

        $fromDate = new \DateTime('2014-03-29 19:59:23');
        $toDate   = new \DateTime('2014-03-30 21:30:00');

        $edge = new EdgeDto();
        $edge->setFromUnLocode($fromUnLocode);
        $edge->setToUnLocode($toUnLocode);
        $edge->setFromDate($fromDate->format(\DateTime::ISO8601));
        $edge->setToDate($toDate->format(\DateTime::ISO8601));

        $transitPath->setEdges([$edge]);

        return [$transitPath];
    }
}
 