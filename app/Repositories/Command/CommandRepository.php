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

    /**
     * Mark a command as "running".
     *
     * @param int $id Command ID
     */
    public function markAsRunning(int $id): void;

    /**
     * Mark a command as "not running".
     *
     * @param int $id Command ID
     */
    public function markAsNotRunning(int $id): void;

    /**
     * Run command.
     *
     * @param int $id Command ID
     */
    public function run(int $id): int;
}
