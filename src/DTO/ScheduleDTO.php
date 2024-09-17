<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\DTO;

class ScheduleDTO
{
    public function __construct(
        public readonly string $firstHour,
        public readonly string $secondHour,
    ) {
    }
}
