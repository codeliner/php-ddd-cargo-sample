<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 18:55
 */

namespace GraphTraversalService\Dto;

/**
 * Class TransitPathDto
 *
 * @package GraphTraversalService\Dto
 * @author Alexander Miertsch <kontakt@codeliner.ws>
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
    public function setEdges($edges)
    {
        $this->edges = $edges;
    }

    /**
     * @return EdgeDto[]
     */
    public function getEdges()
    {
        return $this->edges;
    }


}
 