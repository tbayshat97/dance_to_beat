<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ZoomMeetingType extends Enum
{
    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;
}
