<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\DTO;

use Webmozart\Assert\Assert;

class DrawerCollection
{
    /**
     * @param DrawerDTO[] $drawers
     */
    public function __construct(
        public readonly array $drawers = []
    ) {
    }

    /**
     * @param array<array{number: int, type: string}> $drawerArray
     */
    public static function fromArray(array $drawerArray): self
    {
        $drawers = [];
        foreach ($drawerArray as $drawer) {
            Assert::integer($drawer['number']);
            Assert::stringNotEmpty($drawer['type']);
            $drawers[] = new DrawerDTO($drawer['number'], $drawer['type']);
        }

        return new self($drawers);
    }
}
