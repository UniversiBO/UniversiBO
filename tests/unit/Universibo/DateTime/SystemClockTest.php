<?php
namespace Universibo\DateTime;

use DateTime;

class SystemClockTest extends \PHPUnit_Framework_TestCase
{
    public function testItShouldReturnADateTime()
    {
        $clock = new SystemClock();

        $this->assertInstanceOf(DateTime::class, $clock->currentTime());
    }
}
