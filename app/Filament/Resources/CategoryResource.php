<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

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
                                        Forms\Components\TextInput::make("title.$code")
                                            ->label("Title ($code)")
                                            ->live(onBlur: true)
                                            ->required($code === 'en')
                                            ->minLength(1)
                                            ->maxLength(150)
                                            ->afterStateUpdated(function (string $operation, $state, \Filament\Forms\Set $set) use ($code) {
                                                if ($operation === 'edit') {
                                                    return;
                                                }
                                                $set("slug.$code", Str::slug($state));
                                            }),
                                        Forms\Components\TextInput::make("slug.$code")
                                            ->label("Slug ($code)")
                                            ->required($code === 'en')
                                            // ->required(false)
                                            ->minLength(1)
                                            ->maxLength(150)
                                            ->rules([
                                                function () {
                                                    $recordId = request()->route('record')?->getKey();

                                                    return function (string $attribute, $value, Closure $fail) {
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
                                                },
                                            ]),
                                    ]);
                            })
                            ->toArray()
                    )
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('text_color'),
                Forms\Components\TextInput::make('bg_color'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('slug')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('text_color')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('bg_color')->sortable()->searchable(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn ($record) => url('/blog?category='.$record->slug))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
