<?php

namespace App\Repositories\Command;

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
}
