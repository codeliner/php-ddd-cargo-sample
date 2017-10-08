<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 8/8/15 - 4:42 PM
 */
namespace Codeliner\CargoUI\Container;

use Codeliner\CargoUI\Main;
use Codeliner\CargoUI\RiotCompiler;
use Psr\Container\ContainerInterface;

final class MainFactory
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @return Main
     */
    public function __invoke(ContainerInterface $container): Main
    {
        $config = $container->get('config');

        $cacheEnabled = (isset($config['view']['cache']))? (bool)$config['view']['cache'] : false;
        $layout = (isset($config['view']['layout']) && is_string($config['view']['layout']))
            ? $config['view']['layout'] : 'CargoUI/view/layout/layout.phtml';

        return new Main($layout, $cacheEnabled, $container->get(RiotCompiler::class));
    }
}