<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 18:52
 */

namespace Codeliner\GraphTraversalBackend;

use Codeliner\GraphTraversalBackend\Dto\TransitPathDto;

/**
 * Interface GraphTraversalServiceInterface
 *
 * @package GraphTraversalService
 * @author Alexander Miertsch <contact@prooph.de>
 */
interface GraphTraversalServiceInterface 
{
    /**
     * @param string $fromUnLocode
     * @param string $toUnLocode
     * @return TransitPathDto[]
     */
    public function findShortestPath($fromUnLocode, $toUnLocode): array;
}
 