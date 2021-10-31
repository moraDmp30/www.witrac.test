<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Support\Str;
use TiMacDonald\Log\LogFake;
use Illuminate\Support\Facades\Log;
use App\Services\Crontab\CrontabReader;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrontabReaderTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_array_returned_when_file_opening_fails()
    {
        Log::swap(new LogFake);
        $crontabReader = app()->make(CrontabReader::class);
        $result = $crontabReader->read(['input' => base_path('tests/samples/non-existing-file.txt')]);
        Log::assertLogged('error', function ($message, $context) {
            return Str::contains($message, 'Unable to open file.');
        });
        $this->assertEmpty($result);
    }

    public function test_empty_lines_are_ignored()
    {
        Log::swap(new LogFake);
        $crontabReader = app()->make(CrontabReader::class);
        $result = $crontabReader->read(['input' => base_path('tests/samples/empty-lines-ignored-example.txt')]);
        Log::assertLogged('error', function ($message, $context) {
            return Str::contains($message, 'Line #2 "" ignored because expression and/or action are empty.');
        });

        $this->assertCount(2, $result);
    }

    public function test_incomplete_cron_expressions_are_ignored()
    {
        Log::swap(new LogFake);
        $crontabReader = app()->make(CrontabReader::class);
        $result = $crontabReader->read(['input' => base_path('tests/samples/incomplete-cron-expressions-ignored-example.txt')]);

        Log::assertLogged('error', function ($message, $context) {
            return Str::contains($message, 'Line #2 "* * * ls" ignored because expression and/or action are empty.');
        });
        Log::assertLogged('error', function ($message, $context) {
            return Str::contains($message, 'Line #4 "* * * * ls" ignored because expression and/or action are empty.');
        });
        $this->assertCount(2, $result);
    }

    public function test_wrong_cron_expressions_are_ignored()
    {
        Log::swap(new LogFake);
        $crontabReader = app()->make(CrontabReader::class);
        $result = $crontabReader->read(['input' => base_path('tests/samples/wrong-cron-expressions-ignored-example.txt')]);

        Log::assertLogged('error', function ($message, $context) {
            return Str::contains($message, 'Line #2 "a b c d e ls" ignored because cron expression is not valid.');
        });
        Log::assertLogged('error', function ($message, $context) {
            return Str::contains($message, 'Line #4 "f g h i j ls" ignored because cron expression is not valid.');
        });
        $this->assertCount(2, $result);
    }

    public function test_empty_command_lines_are_ignored()
    {
        Log::swap(new LogFake);
        $crontabReader = app()->make(CrontabReader::class);
        $result = $crontabReader->read(['input' => base_path('tests/samples/empty-commands-ignored-example.txt')]);

        Log::assertLogged('error', function ($message, $context) {
            return Str::contains($message, 'Line #2 "* * * * *" ignored because expression and/or action are empty.');
        });
        $this->assertCount(2, $result);
    }

    public function test_correct_lines_are_converted_into_array()
    {
        $crontabReader = app()->make(CrontabReader::class);
        $result = $crontabReader->read(['input' => base_path('tests/samples/correct.txt')]);

        $this->assertCount(5, $result);
    }
}
