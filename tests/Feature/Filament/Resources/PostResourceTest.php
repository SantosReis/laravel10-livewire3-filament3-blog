<?php

namespace Tests\Feature\Filament\Resources;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;
use Spatie\Tags\Tag;
use Illuminate\Http\UploadedFile;
use App\Filament\Resources\PostResource\Pages\CreatePost;

class PostResourceTest extends TestCase
{

    public $user;

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->actingAs($this->user);
    }

    public function test_can_create_post(): void
    {
        Storage::fake('media');

        $category = Category::factory()->create();
        $tag = Tag::create(['name' => 'Laravel']);

        $formData = [
            'title' => ['en' => 'Hello World'],
            'slug' => ['en' => 'hello-world'],
            'body' => ['en' => '<p>This is a body</p>'],
            'featured' => true,
            'user_id' => $this->user->id,
            'categories' => [$category->id],
            'tags' => [$tag->id],
            'published_at' => now()->format('Y-m-d H:i:s'),
            'image' => UploadedFile::fake()->image('thumb.jpg'),
        ];

        Livewire::test(CreatePost::class)
            ->fillForm($formData)
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('posts', [
            'featured' => true,
            'user_id' => $this->user->id,
        ]);

    }

    public function test_can_edit_post(): void
    {

        $post = Post::factory()->create();

        Livewire::test(\App\Filament\Resources\PostResource\Pages\EditPost::class, [
            'record' => $post->getKey(),
        ])->fillForm([
            'featured' => true,
        ])->call('save')->assertHasNoFormErrors();

        $this->assertTrue((bool) $post->fresh()->featured);
    }

    public function test_can_soft_delete_post(): void
    {
        $post = Post::factory()->create();

        Livewire::test(\App\Filament\Resources\PostResource\Pages\EditPost::class, [
            'record' => $post->getKey(),
        ])->callAction('delete');

        $this->assertSoftDeleted($post);
    }

    public function test_can_restore_post(): void
    {
        $post = Post::factory()->create();
        $post->delete();

        Livewire::test(\App\Filament\Resources\PostResource\Pages\EditPost::class, [
            'record' => $post->getKey(),
        ])->callAction('restore');

        $this->assertFalse($post->fresh()->trashed());
    }
}
