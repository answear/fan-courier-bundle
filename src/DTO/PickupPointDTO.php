<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\DTO;

use Webmozart\Assert\Assert;

readonly class PickupPointDTO
{
    public function __construct(
        public string $id,
        public string $code,
        public string $name,
        public string $routingLocation,
        public string $description,
        public AddressDTO $address,
        public float $latitude,
        public float $longitude,
        public ScheduleCollection $schedule,
        public DrawerCollection $drawer,
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
