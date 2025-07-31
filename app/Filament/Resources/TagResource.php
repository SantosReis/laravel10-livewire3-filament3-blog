<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
// use Spatie\Tags\Tag;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\App;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TagResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TagResource\RelationManagers;

class TagResource extends Resource
{
    protected static ?string $model = \App\Models\Tag::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModel(): string
    {
        return \App\Models\Tag::class;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255)
                    ->afterStateHydrated(function ($component, $state, $record) {
                        $component->state($record?->getTranslation('name', App::getLocale()));
                    })
                    ->dehydrateStateUsing(function ($state) {
                        return ['en' => $state]; // adjust for multilanguage
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->label('ID'),

                // Show the tag name in the current locale
                TextColumn::make('name')
                    ->label('Name')
                    ->formatStateUsing(fn ($state, $record) => $record->getTranslation('name', App::getLocale()))
                    ->sortable()
                    ->searchable(),

                // If you want to show how many posts use this tag, assuming you have posts relation:
                BadgeColumn::make('posts_count')
                    ->label('Posts')
                    ->counts('posts'),  // This requires a 'posts' relation on Tag model

                // Created and updated timestamps if you want
                TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            RelationManagers\PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
