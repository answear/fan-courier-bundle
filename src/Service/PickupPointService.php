<?php

namespace Answear\FanCourierBundle\Service;

use Answear\FanCourierBundle\Client\Client;
use Answear\FanCourierBundle\DTO\PickupPointDTO;
use Answear\FanCourierBundle\Request\GetPickupPointsRequest;
use Answear\FanCourierBundle\Response\GetPickupPointsResponse;
use Psr\Http\Message\ResponseInterface;

class PickupPointService
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @return PickupPointDTO[]
     */
    public function getAll(): array
    {
        $this->client->login();

        $response = $this->client->request(new GetPickupPointsRequest());

        $pickupPointsResponse = GetPickupPointsResponse::fromArray($this->decodeResponse($response));

        return $pickupPointsResponse->pickupPoints;
    }

    private function decodeResponse(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}
