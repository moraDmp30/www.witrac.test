<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Repositories\Command\CommandRepository;

class ShowCommands extends Component
{
    /**
     * @var bool
     */
    protected $is_data_ready;

    /**
     * @var array
     */
    protected $commands;

    /**
     * @var array
     */
    protected $listeners = [
        'deleteCommand' => 'delete',
    ];

    /**
     * Initializes the component.
     */
    public function mount(): void
    {
        $this->is_data_ready = false;
        $this->commands = [];
    }

    /**
     * Renders the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.show-commands', [
            'commands' => $this->isDataReady() ? $this->getCommands() : [],
        ]);
    }

    /**
     * Fetch commands and set data as ready.
     */
    public function fetchCommands(): void
    {
        $commandRepository = app()->make(CommandRepository::class);
        $this->commands = $commandRepository->getCommands();
        // This sleep allows to see spinner...
        sleep(2);
        $this->markDataAsReady();
    }

    /**
     * Checks if data is ready.
     *
     * @return bool
     */
    public function isDataReady(): bool
    {
        return $this->is_data_ready ? true : false;
    }

    /**
     * Marks data as ready.
     */
    public function markDataAsReady(): void
    {
        $this->is_data_ready = true;
    }

    /**
     * Marks data as NOT ready.
     */
    public function markDataAsNotReady(): void
    {
        $this->is_data_ready = false;
    }

    /**
     * Gets commands.
     *
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * Deletes a command.
     *
     * @param int $id Command ID
     */
    public function delete(int $id): void
    {
        $this->markDataAsNotReady();
        $commandRepository = app()->make(CommandRepository::class);
        $commandRepository->delete($id);
        $this->fetchCommands();
    }
}
