<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Request;

interface RequestInterface
{
    public function getEndpoint(): string;

    public function getMethod(): string;

    public function getQueryParams(): array;
}
