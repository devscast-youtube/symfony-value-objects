<?php

declare(strict_types=1);

namespace App\ReadModel;

use Webmozart\Assert\Assert;

/**
 * Class StudentList.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final readonly class StudentList
{
    public function __construct(
        public array $items
    ) {
        Assert::allIsInstanceOf($items, StudentProfile::class);
    }

    public function isEmpty(): bool
    {
        return count($this->items) > 0;
    }
}
