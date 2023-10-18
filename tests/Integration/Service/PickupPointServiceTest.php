<?php

declare(strict_types=1);

namespace Answear\FanCourierBundle\Tests\Integration\Service;

use Answear\FanCourierBundle\Client\Client;
use Answear\FanCourierBundle\Client\RequestTransformer;
use Answear\FanCourierBundle\ConfigProvider;
use Answear\FanCourierBundle\DTO\PickupPointDTO;
use Answear\FanCourierBundle\Logger\FanCourierLogger;
use Answear\FanCourierBundle\Service\PickupPointService;
use Answear\FanCourierBundle\Tests\MockGuzzleTrait;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class PickupPointServiceTest extends TestCase
{
    use MockGuzzleTrait;

    private Client $client;

    public function setUp(): void
    {
        parent::setUp();

        $configProvider = new ConfigProvider('clientId', 'username', 'password', 'www.softwear.co');
        $this->client = new Client(
            new RequestTransformer($configProvider),
            new FanCourierLogger(new NullLogger()),
            $this->setupGuzzleClient()
        );
    }

    #[Test]
    public function successfulFindPoints(): void
    {
        $service = $this->getService();
        $this->mockGuzzleResponse(new Response(200, [], $this->getSuccessfulBody()));

        $pickupPoints = $service->getAll();

        $this->assertCount(1, $pickupPoints);
        $this->assertPoint($pickupPoints[0]);
    }

    private function assertPoint(PickupPointDTO $pickupPoint): void
    {
        $this->assertNotNull($pickupPoint);
        $this->assertSame($pickupPoint->id, 'FAN0039');
        $this->assertSame($pickupPoint->name, 'FANbox Kaufland Theodor Pallady');
        $this->assertSame($pickupPoint->routingLocation, 'FANbox Kaufland Theodor Pallady (Locker)');
        $this->assertSame($pickupPoint->description, 'In dreapta intrarii principale');
        $this->assertSame($pickupPoint->county, 'Bucuresti');
        $this->assertSame($pickupPoint->locality, 'Bucuresti');
        $this->assertSame($pickupPoint->address, 'Bd. Theodor Pallady, Nr. 51');
        $this->assertSame($pickupPoint->zipCode, '32258');
        $this->assertSame($pickupPoint->locationReference, 'In dreapta intrarii principale');
        $this->assertSame($pickupPoint->latitude, 44.40874);
        $this->assertSame($pickupPoint->longitude, 26.19726);
        $this->assertCount(7, $pickupPoint->schedule->schedules);
        $this->assertCount(3, $pickupPoint->drawer->drawers);
    }

    private function getService(): PickupPointService
    {
        return new PickupPointService($this->client);
    }

    private function getSuccessfulBody(): string
    {
        return file_get_contents(__DIR__ . '/data/exampleResponse.json');
    }
}
