<?php

namespace App\Jobs;

use Exception;
use App\Events\CommandRun;
use App\Events\CommandFailed;
use Illuminate\Bus\Queueable;
use App\Events\PublicCommandCompleted;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repositories\Command\CommandRepository;

class RunCommand implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    protected $userId;

    /**
     * @var int
     */
    protected $commandId;

    /**
     * Create a new job instance.
     *
     * @param int $userId
     * @param int $commandId
     */
    public function __construct(int $userId, int $commandId)
    {
        $this->userId = $userId;
        $this->commandId = $commandId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $repository = app()->make(CommandRepository::class);
            $repository->markAsRunning($this->commandId);

            $repository->run($this->commandId);
            // This sleep allows to see different alerts...
            sleep(5);

            $repository->markAsNotRunning($this->commandId);
            broadcast(new PublicCommandCompleted($this->commandId));
            broadcast(new CommandRun($this->userId, $this->commandId));
        } catch (Exception $e) {
            logger()->error($e);

            throw $e;
        }
    }

    /**
     * The job failed to process.
     *
     * @param Exception $exception
     */
    public function failed(Exception $exception)
    {
        $repository = app()->make(CommandRepository::class);
        $repository->markAsNotRunning($this->commandId);

        broadcast(new PublicCommandCompleted($this->commandId));
        broadcast(new CommandFailed($this->userId, $this->commandId));
    }
}
