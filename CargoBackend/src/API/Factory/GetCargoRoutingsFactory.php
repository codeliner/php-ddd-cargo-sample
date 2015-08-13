<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 8/12/15 - 11:16 PM
 */
namespace Codeliner\CargoBackend\API\Factory;

use Codeliner\CargoBackend\API\Action\GetCargoRoutings;
use Interop\Container\ContainerInterface;

final class GetCargoRoutingsFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new GetCargoRoutings();
    }
} 