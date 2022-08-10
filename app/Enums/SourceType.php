<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class SourceType extends Enum
{
    const Normal = 1;
    const Facebook = 2;
    const Apple = 3;
    const Google = 4;
    const Invited = 5;
}
