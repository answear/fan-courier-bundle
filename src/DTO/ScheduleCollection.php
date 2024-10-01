<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\DTO;

use Webmozart\Assert\Assert;

readonly class ScheduleCollection
{
    /**
     * @param ScheduleDTO[] $schedules
     */
    public function __construct(
        public array $schedules = [],
    ) {
    }

    /**
     * @param array<array{firstHour: string, secondHour: string}> $scheduleArray
     */
    public static function fromArray(array $scheduleArray): self
    {
        $schedules = [];
        foreach ($scheduleArray as $schedule) {
            Assert::stringNotEmpty($schedule['firstHour']);
            Assert::stringNotEmpty($schedule['secondHour']);
            $schedules[] = new ScheduleDTO($schedule['firstHour'], $schedule['secondHour']);
        }

        return new self($schedules);
    }
}
