<?php

namespace Tests\Feature\Filament\Resources;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class UserResourceTest extends TestCase
{
    public $user;

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($this->user);
    }

    public function test_can_create_user(): void
    {
        $this->actingAs(User::factory()->create(['role' => User::ROLE_ADMIN]));

        $formData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'secret123', // Livewire will hash it
            'role' => User::ROLE_EDITOR,
        ];

        Livewire::test(\App\Filament\Resources\UserResource\Pages\CreateUser::class)
            ->fillForm($formData)
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => User::ROLE_EDITOR,
        ]);
    }

    public function test_can_edit_user(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_USER]);

        Livewire::test(\App\Filament\Resources\UserResource\Pages\EditUser::class, [
            'record' => $user->getKey(),
        ])
            ->fillForm([
                'role' => User::ROLE_EDITOR,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertEquals(User::ROLE_EDITOR, $user->fresh()->role);
    }

}
