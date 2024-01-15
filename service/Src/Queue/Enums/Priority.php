<?php

declare(strict_types=1);

namespace Queue\Enums;

enum Priority: int
{
    case HIGH = 0;
    case MEDIUM = 1;
    case LOW = 2;
}