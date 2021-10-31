<?php

namespace App\Services\Crontab;

use Cron\CronExpression;
use Illuminate\Support\Arr;

class FileCrontabReader implements CrontabReader
{
    /**
     * {@inheritdoc}
     */
    public function read($params): array
    {
        $result = [];
        $file = Arr::get($params, 'input', null);
        $handle = fopen($file->getRealPath(), 'r');
        if ($handle === false) {
            logger()->error('Unable to open file');

            return [];
        }

        while (($line = fgets($handle)) !== false) {
            $expressionArray = explode(' ', str_replace(["\r", "\n"], '', $line));
            $cronExpression = implode(' ', array_slice($expressionArray, 0, 5));
            $cronAction = implode(' ', array_slice($expressionArray, 5));

            if (empty($cronExpression) || empty($cronAction)) {
                // Ignore those expressions being empty
                continue;
            }

            $cronExpressionObject = new CronExpression($cronExpression);
            if (!$cronExpressionObject->isValid()) {
                logger()->error('"'.$cronExpression.'" is not valid.');

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
