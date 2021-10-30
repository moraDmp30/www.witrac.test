<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\Crontab\CrontabReader;

class UploadCommandFile extends Component
{
    use WithFileUploads;

    /**
     * @var \Illuminate\Http\UploadedFile
     */
    public $file;

    /**
     * @var bool
     */
    public $delete_previous;

    /**
     * Initializes the component.
     */
    public function mount(): void
    {
        $this->file = null;
        $this->delete_previous = 0;
    }

    /**
     * Renders the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.upload-command-file');
    }

    public function save()
    {
        $this->validate([
            'file' => 'required|mimetypes:text/plain|max:1024', // 1MB Max
            'delete_previous' => 'required|in:0,1',
        ]);

        if ($this->file->isValid()) {
            $reader = app()->make(CrontabReader::class);
            $commands = $reader->read(['input' => $this->file]);
        }

        $this->file = null;
        $this->delete_previous = 0;
        $this->render();
    }
}
