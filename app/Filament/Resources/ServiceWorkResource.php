<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceWorkResource\Pages;
use App\Models\ServiceWork;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceWorkResource extends Resource
{
    protected static ?string $model = ServiceWork::class;
    protected static ?string $modelLabel = 'Фото услуг';
    protected static ?string $pluralLabel = 'Фото услуг';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('thumbnail')
                    ->label('Изображение')
                    ->directory('/files/service_works')
                ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->width(100)
                    ->label('Изображение'),
                Tables\Columns\TextColumn::make('position')
                    ->label('Позиция'),
            ])
            ->reorderable('position')
            ->defaultSort('position')
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListServiceWorks::route('/'),
            'create' => Pages\CreateServiceWork::route('/create'),
            'edit' => Pages\EditServiceWork::route('/{record}/edit'),
        ];
    }
}
