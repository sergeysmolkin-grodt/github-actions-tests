<?php

namespace App\Exceptions;

class CouldNotDeleteZoomMeeting extends \Exception
{
    public function __construct(string $message, ?\Throwable $throwable = null)
    {
        parent::__construct($message, previous: $throwable);
    }
}
