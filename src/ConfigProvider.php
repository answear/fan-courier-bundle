<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle;

class ConfigProvider
{
    public function __construct(
        public readonly string $username,
        public readonly string $password,
        public readonly string $apiUrl,
    ) {
    }
}
