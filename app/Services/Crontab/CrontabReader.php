<?php

namespace App\Services\Crontab;

interface CrontabReader
{
    /**
     * Reads crontab source.
     *
     * @param array $params
     *
     * @return array
     */
    public function read($params): array;
}
