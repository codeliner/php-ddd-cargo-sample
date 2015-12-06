<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Codeliner\CargoBackend\Model\Cargo\Exception;

/**
 * CargoException Class of an InvalidArgumentException
 * 
 * @author Alexander Miertsch <contact@prooph.de>
 */
class InvalidArgumentException extends \InvalidArgumentException implements CargoException
{
}
