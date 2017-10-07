<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 20:39
 */

namespace CodelinerTest\GraphTraversalService;

use Codeliner\GraphTraversalBackend\GraphTraversalService;

class GraphTraversalServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_finds_a_list_of_transit_paths(): void
    {
        $routes = array(
            array(
                'origin' => 'DEHAM',
                'destination' => 'USNYC',
                'duration' => 10,
                'stops' => array(
                    'NLRTM' => 1,
                    'SESTO' => 2
                )
            )
        );

        $graphTraversalService = new GraphTraversalService($routes);

        $transitPaths = $graphTraversalService->findShortestPath('DEHAM', 'USNYC');

        $this->assertEquals(1, count($transitPaths));

        $transitPath = $transitPaths[0];

        $this->assertInstanceOf('Codeliner\GraphTraversalBackend\Dto\TransitPathDto', $transitPath);

        $edges = $transitPath->getEdges();

        $this->assertEquals(3, count($edges));

        $this->assertInstanceOf('Codeliner\GraphTraversalBackend\Dto\EdgeDto', $edges[0]);

        $this->assertEquals('DEHAM', $edges[0]->getFromUnLocode());
        $this->assertEquals('NLRTM', $edges[0]->getToUnLocode());

        $now = new \DateTime();
        $fromDateFirstEdge = new \DateTime($edges[0]->getFromDate());
        $toDateFirstEdge   = new \DateTime($edges[0]->getToDate());

        $this->assertGreaterThan($now->getTimestamp(), $fromDateFirstEdge->getTimestamp());
        $this->assertGreaterThan($fromDateFirstEdge->getTimestamp(), $toDateFirstEdge->getTimestamp());

        $this->assertEquals('NLRTM', $edges[1]->getFromUnLocode());
        $this->assertEquals('SESTO', $edges[1]->getToUnLocode());

        $fromDateSecondEdge = new \DateTime($edges[1]->getFromDate());
        $toDateSecondEdge   = new \DateTime($edges[1]->getToDate());

        $this->assertGreaterThan($toDateFirstEdge->getTimestamp(), $fromDateSecondEdge->getTimestamp());
        $this->assertGreaterThan($fromDateSecondEdge->getTimestamp(), $toDateSecondEdge->getTimestamp());

        $this->assertEquals('SESTO', $edges[2]->getFromUnLocode());
        $this->assertEquals('USNYC', $edges[2]->getToUnLocode());

        $fromDateThirdEdge = new \DateTime($edges[2]->getFromDate());
        $toDateThirdEdge   = new \DateTime($edges[2]->getToDate());

        $this->assertGreaterThan($toDateSecondEdge->getTimestamp(), $fromDateThirdEdge->getTimestamp());
        $this->assertGreaterThan($fromDateThirdEdge->getTimestamp(), $toDateThirdEdge->getTimestamp());
    }
}
 