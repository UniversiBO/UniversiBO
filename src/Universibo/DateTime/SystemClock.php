<?php
namespace Universibo\DateTime;

use DateTime;

final class SystemClock implements Clock
{
    public function currentTime()
    {
        return new DateTime();
    }
}
