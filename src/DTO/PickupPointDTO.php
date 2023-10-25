<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\DTO;

use Webmozart\Assert\Assert;

class PickupPointDTO
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $routingLocation,
        public readonly string $description,
        public readonly string $county,
        public readonly string $locality,
        public readonly string $address,
        public readonly string $zipCode,
        public readonly string $locationReference,
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly ScheduleCollection $schedule,
        public readonly DrawerCollection $drawer
    ) {
    }

    public static function fromArray(array $pickupPoint): self
    {
        Assert::stringNotEmpty($pickupPoint['Id']);
        Assert::stringNotEmpty($pickupPoint['Name']);
        Assert::stringNotEmpty($pickupPoint['RoutingLocation']);
        Assert::stringNotEmpty($pickupPoint['Description']);
        Assert::stringNotEmpty($pickupPoint['County']);
        Assert::stringNotEmpty($pickupPoint['Locality']);
        Assert::stringNotEmpty($pickupPoint['Address']);
        Assert::stringNotEmpty($pickupPoint['ZipCode']);
        Assert::stringNotEmpty($pickupPoint['LocationReference']);
        Assert::float($pickupPoint['Latitude']);
        Assert::float($pickupPoint['Longitude']);
        Assert::range($pickupPoint['Latitude'], -90, 90);
        Assert::range($pickupPoint['Longitude'], -180, 180);
        Assert::count($pickupPoint['Schedule'], 7);

        return new self(
            $pickupPoint['Id'],
            $pickupPoint['Name'],
            $pickupPoint['RoutingLocation'],
            $pickupPoint['Description'],
            $pickupPoint['County'],
            $pickupPoint['Locality'],
            $pickupPoint['Address'],
            $pickupPoint['ZipCode'],
            $pickupPoint['LocationReference'],
            $pickupPoint['Latitude'],
            $pickupPoint['Longitude'],
            ScheduleCollection::fromArray($pickupPoint['Schedule']),
            DrawerCollection::fromArray($pickupPoint['Drawer'])
        );
    }
}
