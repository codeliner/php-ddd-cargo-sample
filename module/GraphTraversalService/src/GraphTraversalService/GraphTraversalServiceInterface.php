<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 18:52
 */

namespace GraphTraversalService;
use GraphTraversalService\Dto\TransitPathDto;

/**
 * Interface GraphTraversalServiceInterface
 *
 * @package GraphTraversalService
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
interface GraphTraversalServiceInterface 
{
    /**
     * @param string $fromUnLocode
     * @param string $toUnLocode
     * @return TransitPathDto[]
     */
    public function findShortestPath($fromUnLocode, $toUnLocode);
}
 