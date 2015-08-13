<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 8/10/15 - 12:28 AM
 */
namespace Codeliner\CargoBackend\API\Factory;

use Aura\Router\RouterFactory;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Router\Aura;

final class AuraRouterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $router = (new RouterFactory())->newInstance();

        $router->addGet('cargo.backend.api.action.get_cargo_routings', '/cargoroutings');
        $router->addGet('cargo.backend.api.action.get_locations', '/locations');

        //$router->addGet('cargo.read', '/cargoroutings/{tracking_id}');

        //->addTokens([
        //    'tracking_id' => '[a-zA-Z0-9-]{36,36}'
        //])

        return new Aura($router);
    }
} 