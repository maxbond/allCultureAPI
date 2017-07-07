<?php

namespace Maxbond\AllCultureAPI;

trait Dates
{
    /**
     * Convert timestamp to formatted date.
     *
     * @param $timestamp
     * @param $format
     *
     * @return string
     */
    public function getDate(int $timestamp, string $format) : string
    {
        $dateTime = new \DateTime();
        $dateTime->setTimestamp($timestamp / 1000);

        return $dateTime->format($format);
    }

    /**
     * Get timestamp from date.
     *
     * @param $date
     *
     * @return int
     */
    public function getTimestamp(string $date) : int
    {
        $dateTime = new \DateTime($date);

        return $dateTime->getTimestamp() * 1000;
    }
}