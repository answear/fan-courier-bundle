<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Client;

use Answear\FanCourierBundle\ConfigProvider;
use Answear\FanCourierBundle\Request\RequestInterface;
use GuzzleHttp\Psr7\Request as HttpRequest;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface as PsrRequestInterface;

class RequestTransformer implements RequestTransformerInterface
{
    public function __construct(
        private readonly ConfigProvider $configProvider,
    ) {
    }

    public function transform(RequestInterface $request): PsrRequestInterface
    {
        $url = $this->configProvider->apiUrl . $request->getEndpoint();

        $formParams = [
            'username' => $this->configProvider->username,
            'client_id' => $this->configProvider->clientId,
            'user_pass' => $this->configProvider->password,
        ];

        return new HttpRequest(
            $request->getMethod(),
            new Uri($url),
            ['Content-Type' => 'application/x-www-form-urlencoded'],
            http_build_query(array_merge($formParams, $request->getOptions()))
        );
    }
}
