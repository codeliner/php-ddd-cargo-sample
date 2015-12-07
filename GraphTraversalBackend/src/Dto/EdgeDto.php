<?php
/*
 * This file is part of the prooph/php-ddd-cargo-sample.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * Date: 29.03.14 - 18:56
 */
declare(strict_types = 1);

namespace Codeliner\GraphTraversalBackend\Dto;

/**
 * Class EdgeDto
 *
 * @package Codeliner\GraphTraversalService\Dto
 * @author Alexander Miertsch <contact@prooph.de>
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
    public function setFromDate(string $fromDate)
    {
        $this->fromDate = $fromDate;
    }

    /**
     * @return string
     */
    public function getFromDate(): string
    {
        return $this->fromDate;
    }

    /**
     * @param string $fromUnLocode
     */
    public function setFromUnLocode(string $fromUnLocode)
    {
        $this->fromUnLocode = $fromUnLocode;
    }

    /**
     * @return string
     */
    public function getFromUnLocode(): string
    {
        return $this->fromUnLocode;
    }

    /**
     * @param string $toDate
     */
    public function setToDate(string $toDate)
    {
        $this->toDate = $toDate;
    }

    /**
     * @return string
     */
    public function getToDate(): string
    {
        return $this->toDate;
    }

    /**
     * @param string $toUnLocode
     */
    public function setToUnLocode(string $toUnLocode)
    {
        $this->toUnLocode = $toUnLocode;
    }

    /**
     * @return string
     */
    public function getToUnLocode(): string
    {
        return $this->toUnLocode;
    }
}
