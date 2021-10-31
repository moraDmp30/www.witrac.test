<?php

namespace App\Services\Crontab;

use Cron\CronExpression;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class FileCrontabReader implements CrontabReader
{
    /**
     * {@inheritdoc}
     */
    public function read($params): array
    {
        $result = [];
        $filePath = Arr::get($params, 'input', null);
        if (!file_exists($filePath) || ($handle = fopen($filePath, 'r')) === false) {
            Log::error('Unable to open file.');

            return [];
        }

        $numLine = 0;
        while (($line = fgets($handle)) !== false) {
            $line = str_replace(["\r", "\n"], '', $line);
            $numLine += 1;
            $expressionArray = explode(' ', $line);
            $cronExpression = implode(' ', array_slice($expressionArray, 0, 5));
            $cronAction = implode(' ', array_slice($expressionArray, 5));

            if (empty($cronExpression) || empty($cronAction)) {
                Log::error('Line #'.$numLine.' "'.$line.'" ignored because expression and/or action are empty.');

                continue;
            }

            $cronExpressionObject = new CronExpression($cronExpression);
            if (!$cronExpressionObject->isValid()) {
                Log::error('Line #'.$numLine.' "'.$line.'" ignored because cron expression is not valid.');

                continue;
            }

            $result[] = [
                'frequency' => $cronExpression,
                'command' => $cronAction,
            ];
        }

        fclose($handle);

        return $result;
    }
}
