<?php

namespace Tests\Feature\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\CategoryResource\Pages\EditCategory;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryResourceTest extends TestCase
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

    public function test_can_create_category(): void
    {
        $formData = [
            'title' => ['en' => 'Tech', 'pt' => 'Tecnologia'],
            'slug' => ['en' => 'tech', 'pt' => 'tecnologia'],
            'text_color' => '#ffffff',
            'bg_color' => '#000000',
        ];

        Livewire::test(CreateCategory::class)
            ->fillForm($formData)
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('categories', [
            'text_color' => '#ffffff',
            'bg_color' => '#000000',
        ]);
    }

    public function test_can_edit_category(): void
    {
        $category = Category::factory()->create([
            'text_color' => '#111111',
            'bg_color' => '#222222',
        ]);

        Livewire::test(EditCategory::class, [
            'record' => $category->getKey(),
        ])
            ->fillForm([
                'text_color' => '#333333',
                'bg_color' => '#444444',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'text_color' => '#333333',
            'bg_color' => '#444444',
        ]);
    }

    public function test_can_delete_category(): void
    {
        $category = Category::factory()->create();

        Livewire::test(EditCategory::class, [
            'record' => $category->getKey(),
        ])
            ->callAction('delete');

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

}
