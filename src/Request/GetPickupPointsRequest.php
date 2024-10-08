<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Request;

class GetPickupPointsRequest implements RequestInterface
{
    private const ENDPOINT = '/reports/pickup-points';
    private const HTTP_METHOD = 'GET';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }

    public function getMethod(): string
    {
        return self::HTTP_METHOD;
    }

    public function getQueryParams(): array
    {
        return ['type' => 'fanbox'];
    }
}
