<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\DTO;

use Webmozart\Assert\Assert;

class ScheduleCollection
{
    /**
     * @param ScheduleDTO[] $schedules
     */
    public function __construct(
        public readonly array $schedules = []
    ) {
    }

    /**
     * @param array<array{startHour: string, stopHour: string}> $scheduleArray
     */
    public static function fromArray(array $scheduleArray): self
    {
        $schedules = [];
        foreach ($scheduleArray as $schedule) {
            Assert::stringNotEmpty($schedule['startHour']);
            Assert::stringNotEmpty($schedule['stopHour']);
            $schedules[] = new ScheduleDTO($schedule['startHour'], $schedule['stopHour']);
        }

        return new self($schedules);
    }
}
