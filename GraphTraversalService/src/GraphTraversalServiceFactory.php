<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 01.03.14 - 22:49
 */

namespace Codeliner\GraphTraversalService;

use Interop\Container\ContainerInterface;

/**
 * Class GraphTraversalServiceFactory
 *
 * @package Application\Service
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class GraphTraversalServiceFactory
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @return mixed
     */
    public function __invoke(ContainerInterface $container)
    {
        return new GraphTraversalService(
            $container->get('config')['itineraries']
        );
    }
}