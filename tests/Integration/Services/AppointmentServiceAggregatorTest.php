<?php

namespace Tests\Integration\Services;

use App\Repositories\AutoScheduleRepository;
use App\Repositories\UserRepository;
use App\Services\AppointmentServicesAggregator;
use App\Services\AutoScheduleService;
use App\Services\CommboxService;
use App\Services\FCMService;
use App\Services\ZoomService;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;


final class AppointmentServiceAggregatorTest extends TestCase
{

    protected AppointmentServicesAggregator $aggregator;

    #[Before]
    protected function setUp() : void
    {
        parent::setUp();

        $autoScheduleRepository = $this->createMock(AutoScheduleRepository::class);
        $userRepository = $this->createMock(UserRepository::class);

        $this->aggregator = new AppointmentServicesAggregator
        (new ZoomService(),
         new FCMService(),
         new CommboxService(),
         new AutoScheduleService($autoScheduleRepository,$userRepository)
        );
    }

    #[Test]
    public function testGetFcmServiceReturnsFcmServiceInstance()
    {
        $result = $this->aggregator->getFCMService();

        $this->assertInstanceOf(FCMService::class, $result);
    }

    #[Test]
    public function testGetZoomServiceReturnsZoomServiceInstance()
    {
        $result = $this->aggregator->getZoomService();

        $this->assertInstanceOf(ZoomService::class, $result);
    }

    #[Test]
    public function testGetWhatsappServiceReturnsWhatsappServiceInstance()
    {
        $result = $this->aggregator->getWhatsAppService();

        $this->assertInstanceOf(CommboxService::class, $result);
    }

    #[Test]
    public function testGetAutoScheduleServiceReturnsAutoScheduleServiceInstance()
    {
        $result = $this->aggregator->getAutoScheduleService();

        $this->assertInstanceOf(AutoScheduleService::class, $result);
    }
}
