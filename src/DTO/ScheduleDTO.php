<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\DTO;

readonly class ScheduleDTO
{
    public function __construct(
        public string $firstHour,
        public string $secondHour,
    ) {
    }
}
