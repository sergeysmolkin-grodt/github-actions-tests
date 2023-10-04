<?php

namespace App\Services;

class AppointmentServicesAggregator
{
    public function __construct(
        protected ZoomService $zoomService,
        protected FCMService $fcmService,
        protected CommboxService $whatsappService,
        protected AutoScheduleService $autoScheduleService
    )
    {}

    public function getZoomService()
    {
        return $this->zoomService;
    }

    public function getFCMService()
    {
        return $this->fcmService;
    }

    public function getWhatsAppService()
    {
        return $this->whatsappService;
    }

    public function getAutoScheduleService()
    {
        return $this->autoScheduleService;
    }
}
