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
     *
     * @return int
     */
    public function run(int $id): int;

    /**
     * Delete command.
     *
     * @param int $id Command ID
     *
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Delete all existing commands.
     *
     * @return bool
     */
    public function deleteAll(): bool;

    /**
     * Insert a bunch of records from the given data.
     *
     * @param array $commands
     */
    public function insert($commands): void;
}
