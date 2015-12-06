<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <contact@prooph.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 18:56
 */

namespace GraphTraversalService\Dto;

/**
 * Class EdgeDto
 *
 * @package GraphTraversalService\Dto
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class EdgeDto 
{
    /**
     * @var string
     */
    private $fromUnLocode;

    /**
     * @var string
     */
    private $toUnLocode;

    /**
     * @var string ISO8601 formatted date
     */
    private $fromDate;

    /**
     * @var string ISO8601 formatted date
     */
    private $toDate;

    /**
     * @param string $fromDate
     */
    public function setFromDate($fromDate)
    {
        $this->fromDate = $fromDate;
    }

    /**
     * @return string
     */
    public function getFromDate()
    {
        return $this->fromDate;
    }

    /**
     * @param string $fromUnLocode
     */
    public function setFromUnLocode($fromUnLocode)
    {
        $this->fromUnLocode = $fromUnLocode;
    }

    /**
     * @return string
     */
    public function getFromUnLocode()
    {
        return $this->fromUnLocode;
    }

    /**
     * @param string $toDate
     */
    public function setToDate($toDate)
    {
        $this->toDate = $toDate;
    }

    /**
     * @return string
     */
    public function getToDate()
    {
        return $this->toDate;
    }

    /**
     * @param string $toUnLocode
     */
    public function setToUnLocode($toUnLocode)
    {
        $this->toUnLocode = $toUnLocode;
    }

    /**
     * @return string
     */
    public function getToUnLocode()
    {
        return $this->toUnLocode;
    }
}
 