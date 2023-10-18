<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Response;

use Answear\FanCourierBundle\DTO\PickupPointDTO;

class GetPickupPointsResponse implements ResponseInterface
{
    /**
     * @param PickupPointDTO[] $pickupPoints
     */
    public function __construct(
        public readonly array $pickupPoints
    ) {
    }

    public static function fromArray(array $data): self
    {
        $pickupPoints = [];
        foreach ($data as $pickupPoint) {
            $pickupPoints[] = PickupPointDTO::fromArray($pickupPoint);
        }

        return new self($pickupPoints);
    }
}
