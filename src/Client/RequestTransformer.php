<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Client;

use Answear\FanCourierBundle\ConfigProvider;
use Answear\FanCourierBundle\Request\RequestInterface;
use Answear\FanCourierBundle\Serializer\Serializer;
use GuzzleHttp\Psr7\Request as HttpRequest;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface as PsrRequestInterface;

class RequestTransformer implements RequestTransformerInterface
{
    public function __construct(
        private readonly ConfigProvider $configProvider,
        private Serializer $serializer,
    ) {
    }

    public function transform(RequestInterface $request): PsrRequestInterface
    {
        $url = $this->configProvider->apiUrl . $request->getEndpoint();

        if (!empty($request->getQueryParams())) {
            $url .= '?' . http_build_query($request->getQueryParams());
        }

        return new HttpRequest(
            $request->getMethod(),
            new Uri($url),
            ['Content-Type' => 'application/json'],
            'GET' === $request->getMethod() ? null : $this->serializer->serialize($request),
        );
    }
}
