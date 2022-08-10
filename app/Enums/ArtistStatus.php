<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ArtistStatus extends Enum
{
    const Actived = 1;
    const Suspended = 2;
    const Blocked = 3;
}
