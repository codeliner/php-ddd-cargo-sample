<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Date: 29.03.14 - 18:55
 */
declare(strict_types = 1);

namespace Codeliner\GraphTraversalBackend\Dto;

/**
 * Class TransitPathDto
 *
 * @package Codeliner\GraphTraversalService\Dto
 * @author Alexander Miertsch <contact@prooph.de>
 */
class TransitPathDto
{
    /**
     * @var EdgeDto[]
     */
    private $edges;

    /**
     * @param EdgeDto[] $edges
     */
    public function __construct(array $edges)
    {
        $this->setEdges($edges);
    }

    /**
     * @return EdgeDto[]
     */
    public function getEdges(): array
    {
        return $this->edges;
    }

    /**
     * @param EdgeDto[] $edges
     */
    private function setEdges(array $edges): void
    {
        $this->edges = array();

        foreach ($edges as $edge) {
            $this->addEdge($edge);
        }
    }

    /**
     * @param EdgeDto $edge
     */
    private function addEdge(EdgeDto $edge): void
    {
        $this->edges[] = $edge;
    }
}
