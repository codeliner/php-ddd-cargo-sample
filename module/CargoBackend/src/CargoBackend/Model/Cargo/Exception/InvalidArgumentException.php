<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CargoBackend\Model\Cargo\Exception;

/**
 * CargoException Class of an InvalidArgumentException
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class InvalidArgumentException extends \InvalidArgumentException implements CargoException
{
}
