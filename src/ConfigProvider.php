<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle;

readonly class ConfigProvider
{
    public function __construct(
        public string $username,
        public string $password,
        public string $apiUrl,
    ) {
    }
}
