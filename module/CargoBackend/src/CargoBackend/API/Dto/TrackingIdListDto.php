<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 26.03.14 - 21:41
 */

namespace CargoBackend\API\Dto;

/**
 * Class TrackingIdListDto
 *
 * @package CargoBackend\API\Dto
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class TrackingIdListDto 
{
    /**
     * @var array
     */
    private $trackingIds = array();

    /**
     * @param array $trackingIds
     */
    public function setTrackingIds(array $trackingIds)
    {
        $this->trackingIds = $trackingIds;
    }

    /**
     * @return array
     */
    public function getTrackingIds()
    {
        return $this->trackingIds;
    }
}
 