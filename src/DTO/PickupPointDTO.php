<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\DTO;

use Webmozart\Assert\Assert;

class PickupPointDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $code,
        public readonly string $name,
        public readonly string $routingLocation,
        public readonly string $description,
        public readonly AddressDTO $address,
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly ScheduleCollection $schedule,
        public readonly DrawerCollection $drawer,
    ) {
    }

    public static function fromArray(array $pickupPoint): self
    {
        Assert::stringNotEmpty($pickupPoint['id']);
        Assert::stringNotEmpty($pickupPoint['name']);
        Assert::stringNotEmpty($pickupPoint['routingLocation']);
        Assert::stringNotEmpty($pickupPoint['description']);
        Assert::notEmpty($pickupPoint['address']);
        Assert::stringNotEmpty($pickupPoint['latitude']);
        Assert::stringNotEmpty($pickupPoint['longitude']);
        Assert::range((float) $pickupPoint['latitude'], -90, 90);
        Assert::range((float) $pickupPoint['longitude'], -180, 180);
        Assert::count($pickupPoint['schedule'], 7);

        return new self(
            $pickupPoint['id'],
            $pickupPoint['code'],
            $pickupPoint['name'],
            $pickupPoint['routingLocation'],
            $pickupPoint['description'],
            AddressDTO::fromArray($pickupPoint['address']),
            (float) $pickupPoint['latitude'],
            (float) $pickupPoint['longitude'],
            ScheduleCollection::fromArray($pickupPoint['schedule']),
            DrawerCollection::fromArray($pickupPoint['drawer']),
        );
    }
}
