<?php

namespace Tests\Feature\Livewire;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Command;
use Illuminate\Http\UploadedFile;
use App\Http\Livewire\UploadCommandFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommandFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_upload_file()
    {
        $this->actingAs(User::factory()->create());
        $file = new UploadedFile(base_path('tests/samples/correct.txt'), 'correct.txt', 'text/plain', null, true);
        $file->name = 'correct.txt';

        Livewire::test(UploadCommandFile::class)
            ->set('file', $file)
            ->call('uploadFile');

        $this->assertEquals(5, Command::query()->count());
    }

    public function test_upload_file_preserves_previous_results()
    {
        Command::factory()->count(5)->create();
        $this->actingAs(User::factory()->create());
        $file = new UploadedFile(base_path('tests/samples/correct.txt'), 'correct.txt', 'text/plain', null, true);
        $file->name = 'correct.txt';

        Livewire::test(UploadCommandFile::class)
            ->set('file', $file)
            ->call('uploadFile');

        $this->assertEquals(10, Command::query()->count());
    }

    public function test_upload_file_removes_previous_results_if_requested()
    {
        Command::factory()->count(10)->create();
        $this->actingAs(User::factory()->create());
        $file = new UploadedFile(base_path('tests/samples/correct.txt'), 'correct.txt', 'text/plain', null, true);
        $file->name = 'correct.txt';

        Livewire::test(UploadCommandFile::class)
            ->set('file', $file)
            ->set('delete_previous', true)
            ->call('uploadFile');

        $this->assertEquals(5, Command::query()->count());
    }

    public function test_file_is_required()
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(UploadCommandFile::class)
            ->set('file', null)
            ->call('uploadFile')
            ->assertHasErrors(['file' => 'required']);
    }

    public function test_file_has_to_be_a_txt_file()
    {
        $this->actingAs(User::factory()->create());
        $file = UploadedFile::fake()->image('img.png', 10, 10);
        $file->name = 'img.png';

        Livewire::test(UploadCommandFile::class)
            ->set('file', $file)
            ->call('uploadFile')
            ->assertHasErrors(['file' => 'Mimetypes']);
    }
}
