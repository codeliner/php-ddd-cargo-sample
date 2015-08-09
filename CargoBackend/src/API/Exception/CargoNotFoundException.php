<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 26.03.14 - 22:09
 */

namespace Codeliner\CargoBackend\API\Exception;

/**
 * Class CargoNotFoundException
 *
 * @package Codeliner\CargoBackend\API\Exception
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class CargoNotFoundException extends \RuntimeException implements ApiException
{
}
 