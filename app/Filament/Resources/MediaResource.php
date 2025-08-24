<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaResource\Pages;
use Filament\Forms;
// use App\Models\Media;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->disabled(),
                Forms\Components\Placeholder::make('preview')
                    ->label('Preview')
                    ->visible(fn ($record) => $record && $record->getUrl())
                    ->content(fn ($record) => new HtmlString('<img src="'.e($record->getUrl()).'" style="max-width: 200px; max-height: 200px; border-radius: 8px;" />')),
                // Forms\Components\FileUpload::make('file') // optional, replace media file
                //     ->label('Upload New File')
                //     ->directory('media')
                //     ->acceptedFileTypes(['image/*', 'video/*', 'application/pdf']), // adapt to your needs
                Forms\Components\TextInput::make('collection_name')->required(),
                // Forms\Components\Textarea::make('custom_properties')
                //     ->label('Custom Properties (JSON)')
                //     ->rows(5)
                //     ->json(),
                // You can add more fields if needed
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('id') // or if you want to display image URL
                    ->getStateUsing(fn (Media $record) => $record->getUrl())
                    ->label('Preview')
                    ->square()
                    ->size(50),

                Tables\Columns\TextColumn::make('name')->label('Name')->searchable()->sortable(),

                Tables\Columns\TextColumn::make('collection_name')->label('Collection')->sortable(),

                Tables\Columns\TextColumn::make('mime_type')->label('Type'),

                Tables\Columns\TextColumn::make('size')
                    ->label('Size')
                    ->formatStateUsing(fn ($state) => number_format($state / 1024, 2).' KB'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Uploaded')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('collection_name')
                    ->label('Collection')
                    ->options(fn () => Media::query()->distinct()->pluck('collection_name', 'collection_name')->toArray()),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListMedia::route('/'),
            'create' => Pages\CreateMedia::route('/create'),
            'edit' => Pages\EditMedia::route('/{record}/edit'),
        ];
    }
}
