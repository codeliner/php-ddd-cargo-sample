<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 01.03.14 - 22:49
 */
declare(strict_types = 1);

namespace Codeliner\GraphTraversalBackend;

use Psr\Container\ContainerInterface;

/**
 * Class GraphTraversalServiceFactory
 *
 * @package Application\Service
 * @author Alexander Miertsch <contact@prooph.de>
 */
class GraphTraversalServiceFactory
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @return mixed
     */
    public function __invoke(ContainerInterface $container): GraphTraversalService
    {
        return new GraphTraversalService(
            $container->get('config')['itineraries']
        );
    }
}