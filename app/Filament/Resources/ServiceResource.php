<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?string $modelLabel = 'Услуга';
    protected static ?string $pluralLabel = 'Услуги';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationLabel(): string
    {
        return 'Services';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Actions::make([
                Forms\Components\Actions\Action::make('site_url')
                    ->label('На сайт →')
                    ->url(fn(Service $service) => route('services.show', ['slug' => $service->slug]))
                ,
                ])->visibleOn('edit'),
                Forms\Components\Tabs::make()
                ->tabs([
                    Forms\Components\Tabs\Tab::make('Основная информация')
                        ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('fields.title'))
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('slug')
                            ->label(__('fields.slug'))
                            ->prefix('/services/')
                            ->helperText(__('fields.slug_help'))
                            ->maxLength(255)
                            ->visibleOn('edit')
                        ,

                        Forms\Components\Checkbox::make('is_active')
                            ->label(__('fields.is_active'))
                            ->helperText(__('fields.is_active_help')),
                        Forms\Components\Checkbox::make('is_show_homepage')
                            ->label(__('fields.is_show_homepage')),
                        Forms\Components\FileUpload::make('title_img')
                            ->label(__('fields.title_img'))
                            ->directory('/files/services')
                            ->helperText(__('fields.title_img_help'))
                        ,
                        Forms\Components\Select::make('parent_id')
                            ->label(__('fields.parent'))
                            ->options(Service::toTreeSelect())
                            ->rules([
                                fn($get) => function (string $attribute, $value, $fail) use ($get) {
                                    $id = $get('id');
                                    $parentId = $value;
                                    if (Service::IsHasRecursion($id, $parentId)) {
                                        $fail(__('errors.recursion'));
                                    }
                                },
                            ]),
                        TinyEditor::make('body')
                            ->label(__('fields.body'))
                            ->fileAttachmentsDirectory('/files/services')
                            ->columnSpanFull()
                    ]),
                    Forms\Components\Tabs\Tab::make('Мета информация')
                        ->schema([
                            Forms\Components\TextInput::make('meta_title')
                                ->label(__('fields.meta_title'))
                                ->maxLength(255),
                            Forms\Components\TextInput::make('meta_keywords')
                                ->label(__('fields.meta_keywords'))
                                ->helperText(__('fields.meta_keywords_help'))
                                ->maxLength(255),
                            Forms\Components\Textarea::make('meta_description')
                                ->label(__('fields.meta_description'))
                                ->rows(2)
                                ->maxLength(255)
                                ->columnSpanFull()
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('title_img')
                    ->width(100)
                    ->label('Изображение'),
                Tables\Columns\TextColumn::make('title')->label(__('fields.title'))
                    ->searchable(['title', 'slug'])
                ,
                Tables\Columns\TextColumn::make('position')->label('Позиция'),
                Tables\Columns\TextColumn::make('created_at')->label(__('fields.created_at'))->dateTime('d.m.Y H:i'),
                Tables\Columns\TextColumn::make('updated_at')->label(__('fields.updated_at'))->dateTime('d.m.Y H:i'),
                Tables\Columns\ToggleColumn::make('is_active')->label(__('fields.is_active')),
                Tables\Columns\ToggleColumn::make('is_show_homepage')->label('На главной странице'),
            ])
            ->reorderable('position')
            ->defaultSort('position')
            ->filters([
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Родитель')
                    ->options(Service::toTreeSelect()),
                Tables\Filters\Filter::make('is_roots')
                    ->label('Только верхнеуровневые')
                    ->query(fn(Builder $query) => $query->where('parent_id', '=', null))
            ])
            ->actions([
                Tables\Actions\Action::make('site_url')
                    ->label('На сайт →')
                    ->url(fn(Service $service) => route('services.show', ['slug' => $service->slug]))
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }


}
