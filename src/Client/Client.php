<?php

namespace Answear\FanCourierBundle\Client;

use Answear\FanCourierBundle\Exception\RequestException;
use Answear\FanCourierBundle\Exception\ResponseException;
use Answear\FanCourierBundle\Logger\FanCourierLogger;
use Answear\FanCourierBundle\Request\RequestInterface;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Client
{
    private const CONNECTION_TIMEOUT = 10;
    private const TIMEOUT = 30;
    
    public function __construct(
        private readonly RequestTransformerInterface $requestTransformer,
        private readonly FanCourierLogger $logger,
        private ?ClientInterface $client = null,
    ) {
        $this->client ??= new GuzzleClient(['timeout' => self::TIMEOUT, 'connect_timeout' => self::CONNECTION_TIMEOUT]);
    }

    public function request(RequestInterface $request): ResponseInterface
    {
        $this->logger->setRequestId(uniqid('FANCOURIER-', more_entropy: true));

        try {
            $psrRequest = $this->requestTransformer->transform($request);
            $this->logger->logRequest($request->getEndpoint(), $psrRequest);

            $response = $this->client->send($psrRequest);

            $contents = $response->getBody()->getContents();

            $this->logger->logResponse($request->getEndpoint(), $psrRequest, $response);

            if (str_contains($contents, 'errors')) {
                throw new ResponseException($contents);
            }

            if ($response->getBody()->isSeekable()) {
                $response->getBody()->rewind();
            }
        } catch (GuzzleException $exception) {
            $this->logger->logError($request->getEndpoint(), $exception);

            throw new RequestException($exception->getMessage(), $exception->getCode(), $exception);
        } catch (\Throwable $throwable) {
            $this->logger->logError($request->getEndpoint(), $throwable);

            throw $throwable;
        } finally {
            $this->logger->clearRequestId();
        }

        return $response;
    }
}
