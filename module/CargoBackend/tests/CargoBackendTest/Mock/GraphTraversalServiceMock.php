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

namespace CargoBackendTest\Mock;

use GraphTraversalService\Dto\EdgeDto;
use GraphTraversalService\Dto\TransitPathDto;
use GraphTraversalService\GraphTraversalServiceInterface;

/**
 * Class GraphTraversalServiceMock
 *
 * @package CargoBackendTest\Domain\Mock
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class GraphTraversalServiceMock implements GraphTraversalServiceInterface
{
    /**
     * @param string $fromUnLocode
     * @param string $toUnLocode
     * @return TransitPathDto[]
     */
    public function findShortestPath($fromUnLocode, $toUnLocode)
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
 