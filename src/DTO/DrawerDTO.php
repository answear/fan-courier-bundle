<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\DTO;

readonly class DrawerDTO
{
    public function __construct(
        public int $number,
        public string $type,
    ) {
    }
}
