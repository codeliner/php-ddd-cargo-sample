<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Service\Exception;

/**
 *  Service RuntimeException
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class RuntimeException extends \RuntimeException implements ServiceException
{
}
