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
    public function setEdges(array $edges)
    {
        $this->edges = $edges;
    }

    /**
     * @return EdgeDto[]
     */
    public function getEdges(): array
    {
        return $this->edges;
    }
}
