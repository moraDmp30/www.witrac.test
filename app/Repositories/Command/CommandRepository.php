<?php

namespace App\Repositories\Command;

interface CommandRepository
{
    /**
     * Gets commands.
     *
     * @return array
     */
    public function getCommands(): array;
}
