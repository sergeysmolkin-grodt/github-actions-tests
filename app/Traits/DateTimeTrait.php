<?php

namespace App\Traits;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

trait DateTimeTrait
{

    public function convertDateTimeToTimeZone(string $dateTimeString, string $toTimeZone, string $fromTimeZone = 'UTC'): string
    {
        $dateTime = Carbon::createFromFormat('Y-m-d H:i', $dateTimeString, $fromTimeZone);

        return $dateTime->setTimezone($toTimeZone)->toDateTimeString();
    }

    public function getDMYCommaFormat(string $date): string
    {
        return \Carbon\Carbon::parse($date)->format('d M, Y');
    }

    public function addMinutesToDateTime(string $dateTime, int $minutes): string
    {
        $modifiedTimestamp = Carbon::parse($dateTime)->addMinutes($minutes);

        // Format the Carbon instance as a datetime string
        return $modifiedTimestamp->toDateTimeString();
    }

    public function getDMYSlashFormat($date): string
    {
        return \Carbon\Carbon::parse($date)->format('d/m/Y');
    }

    public function getYMDHyphenFormat($date): string
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }

    public function getCarbonInstance(string $dateTime): Carbon
    {
        return Carbon::parse($dateTime);
    }

    public function addDaysToDateTime(string $dateTime, int $days): string
    {
        return Carbon::parse($dateTime)->addDays($days)->toDateTimeString();
    }

    public function addWeekToDate($date): string
    {
        return Carbon::parse($date)->addWeek()->toDateString();
    }

    public function getCurrentDate(): string
    {
        return Carbon::now()->toDateString();
    }

    public function getCurrentDateTime(): string
    {
        return Carbon::now()->toDateTimeString();
    }

    public function nextDateOfDay(string $dayOfWeek): string
    {
        return Carbon::parse('next ' . $dayOfWeek)->toDateString();
    }

    public function getDayNameFromDate(string $date): string
    {
        return Carbon::parse($date)->dayName;
    }

    public function getDayOfWeek(string $date): int
    {
        $carbonDate = Carbon::createFromFormat('Y-m-d', $date);
        return $carbonDate->format('N');
    }
}
