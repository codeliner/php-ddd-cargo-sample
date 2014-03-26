<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 26.03.14 - 22:19
 */

namespace CargoBackend\API\Dto;

/**
 * Class RouteSpecificationDto
 *
 * @package CargoBackend\API\Dto
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class RouteSpecificationDto 
{
    /**
     * @var string
     */
    private $origin;

    /**
     * @var string
     */
    private $destination;

    /**
     * @param string $destination
     */
    public function setDestination($destination)
    {
        \Assert\that($destination)->notEmpty()->string();

        $this->destination = $destination;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param string $origin
     */
    public function setOrigin($origin)
    {
        \Assert\that($origin)->notEmpty()->string();

        $this->origin = $origin;
    }

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }
}
