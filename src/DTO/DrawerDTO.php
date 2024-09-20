<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\DTO;

class DrawerDTO
{
    public function __construct(
        public readonly int $number,
        public readonly string $type,
    ) {
    }
}
