<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Response;

use Answear\FanCourierBundle\DTO\PickupPointDTO;
use Webmozart\Assert\Assert;

class GetPickupPointsResponse implements ResponseInterface
{
    /**
     * @param PickupPointDTO[] $pickupPoints
     */
    public function __construct(
        public readonly string $status,
        public readonly array $pickupPoints,
    ) {
    }

    public static function fromArray(array $data): self
    {
        Assert::same($data['status'], 'success', 'Login failed');

        $pickupPoints = array_map(
            static fn(array $pickupPoint): PickupPointDTO => PickupPointDTO::fromArray($pickupPoint),
            $data['data'],
        );

        return new self($data['status'], $pickupPoints);
    }
}
