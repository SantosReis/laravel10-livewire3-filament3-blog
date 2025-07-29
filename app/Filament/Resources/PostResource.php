<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Translations')
                    ->tabs(
                        collect(config('app.supported_locales'))
                            ->map(function ($locale, $code) {
                                // return Tabs\Tab::make($locale['name'])
                                return Tabs\Tab::make("{$locale['emoji']} {$locale['name']}")
                                    // ->icon('flag-icon-' . $locale['icon']) // optional: needs a flag-icon setup
                                    ->schema([
                                        TextInput::make("title.$code")
                                            ->label("Title ($code)")
                                            ->live(onBlur: true)
                                            ->required($code === 'en')
                                            ->minLength(1)
                                            ->maxLength(150)
                                            ->afterStateUpdated(function (string $operation, $state, \Filament\Forms\Set $set) use ($code) {
                                                if ($operation === 'edit') return;
                                                $set("slug.$code", Str::slug($state));
                                            }),
                                        TextInput::make("slug.$code")
                                            ->label("Slug ($code)")
                                            ->required($code === 'en')
                                            // ->required(false)
                                            ->minLength(1)
                                            ->maxLength(150)
                                            ->rules([
                                                function () use ($code) {
                                                    $recordId = request()->route('record')?->getKey();

                                                    return function (string $attribute, $value, Closure $fail) use ($code, $recordId) {
                                                        if (is_null($value) || $value === '') {
                                                            return;
                                                        }

                                                        // $exists = Post::whereRaw(
                                                        //         "JSON_UNQUOTE(JSON_EXTRACT(slug, '$.\"$code\"')) = ?",
                                                        //         [$value]
                                                        //     )
                                                        //     ->when($recordId, fn ($query) => $query->where('id', '!=', $recordId))
                                                        //     ->exists();

                                                        // if ($exists) {
                                                        //     $fail("The slug for '$code' must be unique.");
                                                        // }
                                                    };
                                                }
                                            ]),
                                        RichEditor::make("body.$code")
                                            ->label("Content ($code)")
                                            ->required($code === 'en')
                                            ->fileAttachmentsDirectory('posts/images')
                                            ->columnSpanFull(),
                                    ]);
                            })
                            ->toArray()
                    )
                    ->columnSpanFull(),
                Section::make('Meta')->schema(
                    [
                        // FileUpload::make('image')->image()->directory('posts/thumbnails'),
                        SpatieMediaLibraryFileUpload::make('image')
                            ->collection('posts') // optional, allows separating media by collection
                            ->image() // Only allow images
                            ->multiple(false)
                            ->responsiveImages(),
                        DateTimePicker::make('published_at')->nullable(),
                        Checkbox::make('featured'),
                        Select::make('user_id')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->required(),
                        Select::make('categories')
                            ->multiple()
                            ->relationship('categories', 'title')
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->getTranslation('title', app()->getLocale()))
                            ->searchable(),
                    ]
                ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('user_id')->numeric()->sortable(),
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('posts')
                    ->rounded(),
                // Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                // Tables\Columns\TextColumn::make('slug')->searchable(),
                Tables\Columns\TextColumn::make('published_at')->dateTime()->sortable(),
                // Tables\Columns\IconColumn::make('featured')->boolean(),
                CheckboxColumn::make('featured'),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn ($record) => url('/blog/' . $record->slug))
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => $record->published_at !== null),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
