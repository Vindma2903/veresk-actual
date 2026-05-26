<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Creagia\FilamentCodeField\CodeField;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $modelLabel = 'Страница';
    protected static ?string $pluralLabel = 'Страницы';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('site_url')
                        ->label('На сайт →')
                        ->url(fn (Page $page) => route('pages.show', ['slug' => $page->slug])),
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
                                    ->helperText(__('fields.slug_help'))
                                    ->maxLength(255)
                                    ->visibleOn('edit'),
                                Forms\Components\Checkbox::make('is_active')
                                    ->label(__('fields.is_active'))
                                    ->helperText(__('fields.is_active_help')),
                                CodeField::make('body_before')
                                    ->htmlField()
                                    ->withLineNumbers()
                                    ->label(__('fields.body_before'))
                                    ->columnSpanFull(),
                                CodeField::make('body')
                                    ->htmlField()
                                    ->withLineNumbers()
                                    ->label(__('fields.body'))
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('attachments')
                                    ->multiple()
                                    ->label('Файлы')
                                    ->imageEditor()
                                    ->appendFiles()
                                    ->openable()
                                    ->directory('/files/pages'),
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
                                    ->columnSpanFull(),
                            ]),

                        Forms\Components\Tabs\Tab::make('Блоки страницы')
                            ->schema([
                                Forms\Components\Repeater::make('blocks_json')
                                    ->label('Блоки страницы')
                                    ->collapsible()
                                    ->collapsed()
                                    ->reorderableWithButtons()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Название')
                                            ->maxLength(255),
                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Активно')
                                            ->default(true),
                                        CodeField::make('before')
                                            ->htmlField()
                                            ->withLineNumbers()
                                            ->label('Блок до содержания')
                                            ->columnSpanFull(),
                                        CodeField::make('content')
                                            ->htmlField()
                                            ->withLineNumbers()
                                            ->label('Содержание')
                                            ->columnSpanFull(),
                                        Forms\Components\FileUpload::make('image')
                                            ->label('Фото')
                                            ->image()
                                            ->imageEditor()
                                            ->openable()
                                            ->directory('/files/pages/blocks/images')
                                            ->columnSpanFull(),
                                        Forms\Components\FileUpload::make('image_1')
                                            ->label('Фото 1')
                                            ->image()
                                            ->imageEditor()
                                            ->openable()
                                            ->directory('/files/pages/blocks/images'),
                                        Forms\Components\FileUpload::make('image_2')
                                            ->label('Фото 2')
                                            ->image()
                                            ->imageEditor()
                                            ->openable()
                                            ->directory('/files/pages/blocks/images'),
                                        Forms\Components\FileUpload::make('image_3')
                                            ->label('Фото 3')
                                            ->image()
                                            ->imageEditor()
                                            ->openable()
                                            ->directory('/files/pages/blocks/images'),
                                        Forms\Components\FileUpload::make('image_4')
                                            ->label('Фото 4')
                                            ->image()
                                            ->imageEditor()
                                            ->openable()
                                            ->directory('/files/pages/blocks/images'),
                                        Forms\Components\FileUpload::make('image_5')
                                            ->label('Фото 5')
                                            ->image()
                                            ->imageEditor()
                                            ->openable()
                                            ->directory('/files/pages/blocks/images'),
                                        Forms\Components\FileUpload::make('image_6')
                                            ->label('Фото 6')
                                            ->image()
                                            ->imageEditor()
                                            ->openable()
                                            ->directory('/files/pages/blocks/images'),
                                        Forms\Components\FileUpload::make('video')
                                            ->label('Видео (mp4)')
                                            ->acceptedFileTypes(['video/mp4'])
                                            ->openable()
                                            ->directory('/files/pages/blocks/videos')
                                            ->columnSpanFull(),
                                        Forms\Components\FileUpload::make('hotspot_image_1')
                                            ->label('Карточка 1: Фото')
                                            ->image()
                                            ->openable()
                                            ->directory('/files/pages/blocks/images'),
                                        Forms\Components\Textarea::make('hotspot_caption_1')
                                            ->label('Карточка 1: Текст')
                                            ->rows(2),
                                        Forms\Components\FileUpload::make('hotspot_image_2')
                                            ->label('Карточка 2: Фото')
                                            ->image()
                                            ->openable()
                                            ->directory('/files/pages/blocks/images'),
                                        Forms\Components\Textarea::make('hotspot_caption_2')
                                            ->label('Карточка 2: Текст')
                                            ->rows(2),
                                        Forms\Components\FileUpload::make('hotspot_image_3')
                                            ->label('Карточка 3: Фото')
                                            ->image()
                                            ->openable()
                                            ->directory('/files/pages/blocks/images'),
                                        Forms\Components\Textarea::make('hotspot_caption_3')
                                            ->label('Карточка 3: Текст')
                                            ->rows(2),
                                        Forms\Components\FileUpload::make('hotspot_image_4')
                                            ->label('Карточка 4: Фото')
                                            ->image()
                                            ->openable()
                                            ->directory('/files/pages/blocks/images'),
                                        Forms\Components\Textarea::make('hotspot_caption_4')
                                            ->label('Карточка 4: Текст')
                                            ->rows(2),
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->sortable()
                    ->searchable(['title', 'slug']),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Ярлык')
                    ->sortable()
                    ->getStateUsing(fn (Page $page) => '/' . $page->slug),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->label(__('fields.created_at'))
                    ->dateTime('d.m.Y H:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->label(__('fields.updated_at'))
                    ->dateTime('d.m.Y H:i'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label(__('fields.is_active')),
            ])
            ->defaultSort('updated_at', 'desc')
            ->actions([
                Tables\Actions\Action::make('site_url')
                    ->label('На сайт →')
                    ->url(fn (Page $page) => route('pages.show', ['slug' => $page->slug])),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
