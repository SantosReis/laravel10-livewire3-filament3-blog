<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\TagResource\Pages\CreateTag;
use App\Filament\Resources\TagResource\Pages\EditTag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Facades\App;

class TagResourceTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create an admin user
        $this->user = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($this->user);
    }

    public function test_can_create_tag(): void
    {
        $formData = [
            'name' => 'Tech',
        ];

        Livewire::test(CreateTag::class)
            ->fillForm($formData)
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('tags', [
            'name->en' => 'Tech',
        ]);
    }

    public function test_can_edit_tag(): void
    {
        $tag = \App\Models\Tag::findOrCreate('OldName', 'en');

        Livewire::test(EditTag::class, [
            'record' => $tag->getKey(),
        ])
            ->fillForm(['name' => 'NewName'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertTrue(\App\Models\Tag::where("name->en", "NewName")->exists());
    }


    public function test_can_delete_tag(): void
    {
        $tag = \App\Models\Tag::findOrCreate('DeleteMe', 'en');

        Livewire::test(EditTag::class, [
            'record' => $tag->getKey(),
        ])
            ->callAction('delete');

        $this->assertFalse(\App\Models\Tag::where("name->en", "DeleteMe")->exists());
    }

}
