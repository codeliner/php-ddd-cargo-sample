<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 8/8/15 - 4:42 PM
 */
namespace Codeliner\CargoUI\Factory;

use Codeliner\CargoUI\Main;
use Interop\Container\ContainerInterface;

final class MainFactory
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @return mixed
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');

        $cacheEnabled = (isset($config['view']['cache']))? (bool)$config['view']['cache'] : false;
        $layout = (isset($config['view']['layout']) && is_string($config['view']['layout']))
            ? $config['view']['layout'] : 'CargoUI/view/layout/layout.phtml';

        return new Main($layout, $cacheEnabled, $container->get('cargo.ui.riot_compiler'));
    }
}