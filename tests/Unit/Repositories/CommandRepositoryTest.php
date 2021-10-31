<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\Command;
use App\Repositories\Command\CommandRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommandRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_running_command_cannot_be_run_again()
    {
        $repository = app()->make(CommandRepository::class);
        $command = Command::factory()->create([
            'is_running' => true,
        ]);

        $this->assertEquals(-1, $repository->run($command->id));
    }
}
