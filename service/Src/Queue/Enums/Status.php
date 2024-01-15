<?php

declare(strict_types=1);

namespace Queue\Enums;

enum Status: int
{
    case SUBMITTED = 0;
    case RETRIEVED = 1;
}