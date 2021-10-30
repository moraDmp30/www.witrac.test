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
            logger()->debug($line);
            logger()->debug($cronExpression);
            logger()->debug($cronAction);

            // if (empty($cronExpression) || empty($cronAction)) {
            //     // Ignore those expressions being empty
            //     continue;
            // }

            $cronExpression = new CronExpression($cronExpression);
            if ($cronExpression->isValid()) {
                logger()->debug('expression valid');
            }
        }

        fclose($handle);

        return [];
    }
}
