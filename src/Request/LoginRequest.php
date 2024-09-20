<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Request;

class LoginRequest implements RequestInterface
{
    private const ENDPOINT = '/login';
    private const HTTP_METHOD = 'POST';

    public function __construct(
        public readonly string $username,
        public readonly string $password,
    ) {
    }

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
        return [];
    }
}
