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
        $this->assertNotNull($pickupPoint);
        $this->assertSame($pickupPoint->id, 'F1000005');
        $this->assertSame($pickupPoint->code, 'FAN0039');
        $this->assertSame($pickupPoint->name, 'FANbox Kaufland Theodor Pallady');
        $this->assertSame($pickupPoint->routingLocation, 'FANbox Kaufland Theodor Pallady (Locker)');
        $this->assertSame($pickupPoint->description, 'In dreapta intrarii principale');
        $this->assertSame($pickupPoint->address->county, 'Bucuresti');
        $this->assertSame($pickupPoint->address->locality, 'Bucuresti');
        $this->assertSame($pickupPoint->address->street, 'Bd. Theodor Pallady');
        $this->assertSame($pickupPoint->address->streetNo, '51');
        $this->assertSame($pickupPoint->address->zipCode, '032258');
        $this->assertSame($pickupPoint->address->reference, 'In dreapta intrarii principale');
        $this->assertSame($pickupPoint->latitude, 44.40874);
        $this->assertSame($pickupPoint->longitude, 26.19726);
        $this->assertCount(7, $pickupPoint->schedule->schedules);
        $this->assertCount(3, $pickupPoint->drawer->drawers);

        $this->assertSame($pickupPoint->schedule->schedules[0]->firstHour, '00:00');
        $this->assertSame($pickupPoint->schedule->schedules[0]->secondHour, '23:59');

        $this->assertSame($pickupPoint->drawer->drawers[0]->type, 'L');
        $this->assertSame($pickupPoint->drawer->drawers[0]->number, 4);
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
