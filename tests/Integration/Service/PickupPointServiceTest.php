<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Tests\Integration\Service;

use Answear\FanCourierBundle\Client\Client;
use Answear\FanCourierBundle\Client\RequestTransformer;
use Answear\FanCourierBundle\ConfigProvider;
use Answear\FanCourierBundle\DTO\PickupPointDTO;
use Answear\FanCourierBundle\Exception\RequestException;
use Answear\FanCourierBundle\Logger\FanCourierLogger;
use Answear\FanCourierBundle\Serializer\Serializer;
use Answear\FanCourierBundle\Service\PickupPointService;
use Answear\FanCourierBundle\Tests\MockGuzzleTrait;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class PickupPointServiceTest extends TestCase
{
    use MockGuzzleTrait;

    private Client $client;
    private LoggerInterface|MockObject $logger;

    public function setUp(): void
    {
        parent::setUp();

        $this->logger = $this->createMock(LoggerInterface::class);

        $configProvider = new ConfigProvider('username', 'password', 'https://api.fancourier.ro');
        $serializer = new Serializer();
        $this->client = new Client(
            new RequestTransformer($configProvider, $serializer),
            new FanCourierLogger($this->logger),
            $configProvider,
            $this->setupGuzzleClient(),
        );
    }

    #[Test]
    public function successfulFindPoints(): void
    {
        $service = $this->getService();

        $this->mockGuzzleResponse(new Response(200, [], $this->getSuccessfulLoginBody()));
        $this->mockGuzzleResponse(new Response(200, [], $this->getSuccessfulPickupPointsBody()));

        $pickupPoints = $service->getAll();

        $this->assertCount(1, $pickupPoints);
        $this->assertPoint($pickupPoints[0]);
    }

    #[Test]
    public function failedLogin(): void
    {
        $service = $this->getService();

        $this->mockGuzzleResponse(new Response(401, []));

        $this->logger->expects(self::once())
            ->method('error')
            ->with('[FANCOURIER] Exception - /login');

        $this->expectException(RequestException::class);

        $service->getAll();
    }

    private function assertPoint(PickupPointDTO $pickupPoint): void
    {
        $this->assertSame('F1000005', $pickupPoint->id);
        $this->assertSame('FAN0039', $pickupPoint->code);
        $this->assertSame('FANbox Kaufland Theodor Pallady', $pickupPoint->name);
        $this->assertSame('FANbox Kaufland Theodor Pallady (Locker)', $pickupPoint->routingLocation);
        $this->assertSame('In dreapta intrarii principale', $pickupPoint->description);
        $this->assertSame('Bucuresti', $pickupPoint->address->county);
        $this->assertSame('Bucuresti', $pickupPoint->address->locality);
        $this->assertSame('Bd. Theodor Pallady', $pickupPoint->address->street);
        $this->assertSame('51', $pickupPoint->address->streetNo);
        $this->assertSame('032258', $pickupPoint->address->zipCode);
        $this->assertSame('In dreapta intrarii principale', $pickupPoint->address->reference);
        $this->assertSame(44.40874, $pickupPoint->latitude);
        $this->assertSame(26.19726, $pickupPoint->longitude);
        $this->assertCount(7, $pickupPoint->schedule->schedules);
        $this->assertCount(3, $pickupPoint->drawer->drawers);

        $this->assertSame('00:00', $pickupPoint->schedule->schedules[0]->firstHour);
        $this->assertSame('23:59', $pickupPoint->schedule->schedules[0]->secondHour);

        $this->assertSame('L', $pickupPoint->drawer->drawers[0]->type);
        $this->assertSame(4, $pickupPoint->drawer->drawers[0]->number);
    }

    private function getService(): PickupPointService
    {
        return new PickupPointService($this->client);
    }

    private function getSuccessfulLoginBody(): string
    {
        return file_get_contents(__DIR__ . '/data/exampleLoginResponse.json');
    }

    private function getSuccessfulPickupPointsBody(): string
    {
        return file_get_contents(__DIR__ . '/data/examplePickupPointsResponse.json');
    }
}
