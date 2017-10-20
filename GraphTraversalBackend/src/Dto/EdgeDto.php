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
     * @param string $fromUnLocode
     * @param string $toUnLocode
     * @param string $fromDate
     * @param string $toDate
     */
    public function __construct(string $fromUnLocode, string $toUnLocode, string $fromDate, string $toDate)
    {
        $this->setFromUnLocode($fromUnLocode);
        $this->setToUnLocode($toUnLocode);
        $this->setFromDate($fromDate);
        $this->setToDate($toDate);
    }

    /**
     * @return string
     */
    public function getFromDate(): string
    {
        return $this->fromDate;
    }

    /**
     * @return string
     */
    public function getFromUnLocode(): string
    {
        return $this->fromUnLocode;
    }

    /**
     * @return string
     */
    public function getToDate(): string
    {
        return $this->toDate;
    }

    /**
     * @return string
     */
    public function getToUnLocode(): string
    {
        return $this->toUnLocode;
    }

    /**
     * @param string $fromDate
     */
    private function setFromDate(string $fromDate): void
    {
        $this->fromDate = $fromDate;
    }

    /**
     * @param string $fromUnLocode
     */
    private function setFromUnLocode(string $fromUnLocode): void
    {
        $this->fromUnLocode = $fromUnLocode;
    }

    /**
     * @param string $toDate
     */
    private function setToDate(string $toDate): void
    {
        $this->toDate = $toDate;
    }

    /**
     * @param string $toUnLocode
     */
    private function setToUnLocode(string $toUnLocode): void
    {
        $this->toUnLocode = $toUnLocode;
    }
}
