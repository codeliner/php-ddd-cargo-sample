<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 17:48
 */
declare(strict_types = 1);

namespace Codeliner\CargoBackend\Application\Booking\Dto;

use Assert\Assertion;

class LocationDto
{
    /**
     * @var string
     */
    private $unLocode;

    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        Assertion::notEmpty($name);
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $unLocode
     */
    public function setUnLocode(string $unLocode): void
    {
        Assertion::notEmpty($unLocode);
        $this->unLocode = $unLocode;
    }

    /**
     * @return string
     */
    public function getUnLocode(): string
    {
        return $this->unLocode;
    }
}
