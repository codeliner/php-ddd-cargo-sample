<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 17:48
 */

namespace Codeliner\CargoBackend\API\Booking\Dto;

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
    public function setName($name)
    {
        \Assert\that($name)->notEmpty()->string();

        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $unLocode
     */
    public function setUnLocode($unLocode)
    {
        \Assert\that($unLocode)->notEmpty()->string();

        $this->unLocode = $unLocode;
    }

    /**
     * @return string
     */
    public function getUnLocode()
    {
        return $this->unLocode;
    }
}
 