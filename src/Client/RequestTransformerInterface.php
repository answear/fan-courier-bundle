<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Client;

use Answear\FanCourierBundle\Request\RequestInterface;
use Psr\Http\Message\RequestInterface as PsrRequestInterface;

interface RequestTransformerInterface
{
    public function transform(RequestInterface $request): PsrRequestInterface;
}
