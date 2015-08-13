<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 8/12/15 - 11:09 PM
 */
namespace Codeliner\CargoBackend\API\Action;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class GetCargoRoutings
{
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next = null)
    {

    }
} 