<?php
/*
 * This file is part of the prooph/cargo-sample2.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 06.12.2015 - 10:44 PM
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Container\Application\Action;

use Psr7Middlewares\Middleware;

final class PayloadParserFactory
{
    public function __invoke(): Middleware\Payload
    {
        return Middleware::Payload();
    }
}
