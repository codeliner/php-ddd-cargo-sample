<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ApplicationTest\Domain\Model\Cargo;

use Application\Domain\Model\Cargo\TrackingId;
use ApplicationTest\TestCase;
/**
 * TrackingIdTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class TrackingIdTest extends TestCase
{
    /**
     * @expectedException Application\Domain\Model\Cargo\Exception\InvalidArgumentException
     */
    public function testConstructNoTrackingId()
    {
        $trackingId = new TrackingId('');
    }
}
