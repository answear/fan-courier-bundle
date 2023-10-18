<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Request;

class GetPickupPointsRequest implements RequestInterface
{
    private const ENDPOINT = '/pickup-points.php';
    private const HTTP_METHOD = 'POST';

    public function getEndpoint(): string
    {
        return self::ENDPOINT;
    }

    public function getMethod(): string
    {
        return self::HTTP_METHOD;
    }

    public function getOptions(): array
    {
        return ['type' => 'fanbox'];
    }
}
