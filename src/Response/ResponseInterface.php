<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Response;

interface ResponseInterface
{
    public static function fromArray(array $data): self;
}
