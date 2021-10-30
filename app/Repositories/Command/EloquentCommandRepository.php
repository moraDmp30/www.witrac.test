<?php

namespace App\Repositories\Command;

use Exception;
use App\Models\Command;
use App\Http\Resources\CommandResource;

class EloquentCommandRepository implements CommandRepository
{
    /**
     * {@inheritdoc}
     */
    public function getCommands(): array
    {
        $commands = Command::all();
        $result = [];
        foreach ($commands as $command) {
            $result[] = (new CommandResource($command))->resolve();
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function markAsRunning(int $id): void
    {
        $command = Command::findOrFail($id);
        $command->is_running = true;
        $command->save();
    }

    /**
     * {@inheritdoc}
     */
    public function markAsNotRunning(int $id): void
    {
        $command = Command::findOrFail($id);
        $command->is_running = false;
        $command->save();
    }

    /**
     * {@inheritdoc}
     */
    public function run(int $id): int
    {
        $command = Command::findOrFail($id);
        if ($command->is_running) {
            return -1;
        }

        $output = [];
        $returnVar = 0;
        exec($command->command, $output, $returnVar);

        if ($returnVar != 0) {
            throw new Exception(serialize($output));
        }

        return $returnVar;
    }
}
