<?php

declare(strict_types=1);

namespace App;

enum StudentCacheKeys: string
{
    case PROFILE = 'student-profile-%s';

    case LIST = 'student-list';

    public function withId(int $id): string
    {
        return \sprintf($this->value, (string) $id);
    }
}
