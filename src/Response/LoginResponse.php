<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Response;

use Webmozart\Assert\Assert;

readonly class LoginResponse implements ResponseInterface
{
    public function __construct(
        public string $token,
        public string $expiresAt,
    ) {
    }

    public static function fromArray(array $data): self
    {
        Assert::same($data['status'], 'success', 'Login failed');
        Assert::notEmpty($data['data']['token'], 'Token is empty');

        return new self(
            $data['data']['token'],
            $data['data']['expiresAt'],
        );
    }
}
