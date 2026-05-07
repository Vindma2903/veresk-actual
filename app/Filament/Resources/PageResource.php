<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Creagia\FilamentCodeField\CodeField;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $modelLabel = 'РЎС‚СЂР°РЅРёС†Р°';
    protected static ?string $pluralLabel = 'РЎС‚СЂР°РЅРёС†С‹';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Actions::make([
                    Forms\Components\Actions\Action::make('site_url')
                        ->label('РќР° СЃР°Р№С‚ в†’')
                        ->url(fn (Page $page) => route('pages.show', ['slug' => $page->slug])),
                ])->visibleOn('edit'),

                Forms\Components\Tabs::make()
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('РћСЃРЅРѕРІРЅР°СЏ РёРЅС„РѕСЂРјР°С†РёСЏ')
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
                                    ->helperText('Р’РёР·СѓР°Р»СЊРЅРѕРµ РѕС‚РѕР±СЂР°Р¶РµРЅРёРµ РіР»Р°РІРЅРѕРіРѕ РЅР°Р·РІР°РЅРёСЏ Р±СѓРґРµС‚ Р·Р°РјРµРЅРµРЅРѕ РїСЂРѕРёР·РІРѕР»СЊРЅС‹Рј РєРѕРЅС‚РµРЅС‚РѕРј РёР· СЌС‚РѕРіРѕ Р±Р»РѕРєР°')
                                    ->columnSpanFull()
                                    ->visible(fn (?Page $record): bool => $record?->slug !== 'landshaftnoe-proektirovanie'),

                                CodeField::make('body')
                                    ->htmlField()
                                    ->withLineNumbers()
                                    ->label(__('fields.body'))
                                    ->columnSpanFull()
                                    ->visible(fn (?Page $record): bool => $record?->slug !== 'landshaftnoe-proektirovanie'),

                                Forms\Components\Repeater::make('blocks_json')
                                    ->label('Р‘Р»РѕРєРё СЃС‚СЂР°РЅРёС†С‹')
                                    ->helperText('Р”Р»СЏ СЃС‚СЂР°РЅРёС†С‹ landshaftnoe-proektirovanie: РґР»СЏ РєР°Р¶РґРѕРіРѕ Р±Р»РѕРєР° Р·Р°РґР°Р№С‚Рµ РќР°Р·РІР°РЅРёРµ, РђРєС‚РёРІРЅРѕ Рё РЎРѕРґРµСЂР¶Р°РЅРёРµ.')
                                    ->columnSpanFull()
                                    ->visible(fn (?Page $record): bool => $record?->slug === 'landshaftnoe-proektirovanie')
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('РќР°Р·РІР°РЅРёРµ')
                                            ->placeholder('Р‘Р»РѕРє 1')
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\Toggle::make('is_active')
                                            ->label('РђРєС‚РёРІРЅРѕ')
                                            ->default(true),

                                        CodeField::make('body')
                                            ->htmlField()
                                            ->withLineNumbers()
                                            ->label(__('fields.body')),

                                        Forms\Components\Placeholder::make('photo_1_preview')
                                            ->label('Р¤РѕС‚Рѕ 1')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 5')
                                            ->content(fn (Get $get): HtmlString => self::buildImagePreviewHtml(self::resolveBlockImageByIndex(0, $get('images'), $get('image'), $get('body')))),
                                        Forms\Components\FileUpload::make('image_1')
                                            ->label('Р—Р°РјРµРЅРёС‚СЊ С„РѕС‚Рѕ 1')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 5')
                                            ->image()
                                            ->disk('public')
                                            ->directory('files/pages/blocks')
                                            ->visibility('public')
                                            ->imageEditor(),

                                        Forms\Components\Placeholder::make('photo_2_preview')
                                            ->label('Р¤РѕС‚Рѕ 2')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 5')
                                            ->content(fn (Get $get): HtmlString => self::buildImagePreviewHtml(self::resolveBlockImageByIndex(1, $get('images'), $get('image'), $get('body')))),
                                        Forms\Components\FileUpload::make('image_2')
                                            ->label('Р—Р°РјРµРЅРёС‚СЊ С„РѕС‚Рѕ 2')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 5')
                                            ->image()
                                            ->disk('public')
                                            ->directory('files/pages/blocks')
                                            ->visibility('public')
                                            ->imageEditor(),

                                        Forms\Components\Placeholder::make('photo_3_preview')
                                            ->label('Р¤РѕС‚Рѕ 3')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 5')
                                            ->content(fn (Get $get): HtmlString => self::buildImagePreviewHtml(self::resolveBlockImageByIndex(2, $get('images'), $get('image'), $get('body')))),
                                        Forms\Components\FileUpload::make('image_3')
                                            ->label('Р—Р°РјРµРЅРёС‚СЊ С„РѕС‚Рѕ 3')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 5')
                                            ->image()
                                            ->disk('public')
                                            ->directory('files/pages/blocks')
                                            ->visibility('public')
                                            ->imageEditor(),

                                        Forms\Components\Placeholder::make('photo_4_preview')
                                            ->label('Р¤РѕС‚Рѕ 4')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 5')
                                            ->content(fn (Get $get): HtmlString => self::buildImagePreviewHtml(self::resolveBlockImageByIndex(3, $get('images'), $get('image'), $get('body')))),
                                        Forms\Components\FileUpload::make('image_4')
                                            ->label('Р—Р°РјРµРЅРёС‚СЊ С„РѕС‚Рѕ 4')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 5')
                                            ->image()
                                            ->disk('public')
                                            ->directory('files/pages/blocks')
                                            ->visibility('public')
                                            ->imageEditor(),

                                        Forms\Components\Placeholder::make('photo_5_preview')
                                            ->label('Р¤РѕС‚Рѕ 5')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 5')
                                            ->content(fn (Get $get): HtmlString => self::buildImagePreviewHtml(self::resolveBlockImageByIndex(4, $get('images'), $get('image'), $get('body')))),
                                        Forms\Components\FileUpload::make('image_5')
                                            ->label('Р—Р°РјРµРЅРёС‚СЊ С„РѕС‚Рѕ 5')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 5')
                                            ->image()
                                            ->disk('public')
                                            ->directory('files/pages/blocks')
                                            ->visibility('public')
                                            ->imageEditor(),

                                        Forms\Components\Placeholder::make('photo_6_preview')
                                            ->label('Р¤РѕС‚Рѕ 6')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 5')
                                            ->content(fn (Get $get): HtmlString => self::buildImagePreviewHtml(self::resolveBlockImageByIndex(5, $get('images'), $get('image'), $get('body')))),
                                        Forms\Components\FileUpload::make('image_6')
                                            ->label('Р—Р°РјРµРЅРёС‚СЊ С„РѕС‚Рѕ 6')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 5')
                                            ->image()
                                            ->disk('public')
                                            ->directory('files/pages/blocks')
                                            ->visibility('public')
                                            ->imageEditor(),
                                        Forms\Components\Placeholder::make('photo_9_preview')
                                            ->label('Р¤РѕС‚Рѕ')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 9')
                                            ->content(fn (Get $get): HtmlString => self::buildImagePreviewHtml(self::resolveBlockImageByIndex(0, $get('images'), $get('image'), $get('body')))),
                                        Forms\Components\FileUpload::make('image')
                                            ->label('Р—Р°РјРµРЅРёС‚СЊ С„РѕС‚Рѕ')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 9')
                                            ->image()
                                            ->disk('public')
                                            ->directory('files/pages/blocks')
                                            ->visibility('public')
                                            ->imageEditor(),
                                        Forms\Components\Placeholder::make('hotspot_1_photo_preview')
                                            ->label('РљР°СЂС‚РѕС‡РєР° 1: Р¤РѕС‚Рѕ')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 9')
                                            ->content(fn (Get $get): HtmlString => self::buildImagePreviewHtml(self::resolveHotspotImageByIndex(0, $get('body')))),
                                        Forms\Components\FileUpload::make('hotspot_image_1')
                                            ->label('РљР°СЂС‚РѕС‡РєР° 1: Р—Р°РјРµРЅРёС‚СЊ С„РѕС‚Рѕ')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 9')
                                            ->image()
                                            ->disk('public')
                                            ->directory('files/pages/blocks/hotspots')
                                            ->visibility('public')
                                            ->imageEditor(),
                                        Forms\Components\Textarea::make('hotspot_caption_1')
                                            ->label('РљР°СЂС‚РѕС‡РєР° 1: РўРµРєСЃС‚')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 9')
                                            ->rows(2)
                                            ->formatStateUsing(fn ($state, Get $get): ?string => filled($state) ? (string) $state : self::resolveHotspotCaptionByIndex(0, $get('body'))),

                                        Forms\Components\Placeholder::make('hotspot_2_photo_preview')
                                            ->label('РљР°СЂС‚РѕС‡РєР° 2: Р¤РѕС‚Рѕ')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 9')
                                            ->content(fn (Get $get): HtmlString => self::buildImagePreviewHtml(self::resolveHotspotImageByIndex(1, $get('body')))),
                                        Forms\Components\FileUpload::make('hotspot_image_2')
                                            ->label('РљР°СЂС‚РѕС‡РєР° 2: Р—Р°РјРµРЅРёС‚СЊ С„РѕС‚Рѕ')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 9')
                                            ->image()
                                            ->disk('public')
                                            ->directory('files/pages/blocks/hotspots')
                                            ->visibility('public')
                                            ->imageEditor(),
                                        Forms\Components\Textarea::make('hotspot_caption_2')
                                            ->label('РљР°СЂС‚РѕС‡РєР° 2: РўРµРєСЃС‚')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 9')
                                            ->rows(2)
                                            ->formatStateUsing(fn ($state, Get $get): ?string => filled($state) ? (string) $state : self::resolveHotspotCaptionByIndex(1, $get('body'))),

                                        Forms\Components\Placeholder::make('hotspot_3_photo_preview')
                                            ->label('РљР°СЂС‚РѕС‡РєР° 3: Р¤РѕС‚Рѕ')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 9')
                                            ->content(fn (Get $get): HtmlString => self::buildImagePreviewHtml(self::resolveHotspotImageByIndex(2, $get('body')))),
                                        Forms\Components\FileUpload::make('hotspot_image_3')
                                            ->label('РљР°СЂС‚РѕС‡РєР° 3: Р—Р°РјРµРЅРёС‚СЊ С„РѕС‚Рѕ')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 9')
                                            ->image()
                                            ->disk('public')
                                            ->directory('files/pages/blocks/hotspots')
                                            ->visibility('public')
                                            ->imageEditor(),
                                        Forms\Components\Textarea::make('hotspot_caption_3')
                                            ->label('РљР°СЂС‚РѕС‡РєР° 3: РўРµРєСЃС‚')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 9')
                                            ->rows(2)
                                            ->formatStateUsing(fn ($state, Get $get): ?string => filled($state) ? (string) $state : self::resolveHotspotCaptionByIndex(2, $get('body'))),

                                        Forms\Components\Placeholder::make('hotspot_4_photo_preview')
                                            ->label('РљР°СЂС‚РѕС‡РєР° 4: Р¤РѕС‚Рѕ')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 9')
                                            ->content(fn (Get $get): HtmlString => self::buildImagePreviewHtml(self::resolveHotspotImageByIndex(3, $get('body')))),
                                        Forms\Components\FileUpload::make('hotspot_image_4')
                                            ->label('РљР°СЂС‚РѕС‡РєР° 4: Р—Р°РјРµРЅРёС‚СЊ С„РѕС‚Рѕ')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 9')
                                            ->image()
                                            ->disk('public')
                                            ->directory('files/pages/blocks/hotspots')
                                            ->visibility('public')
                                            ->imageEditor(),
                                        Forms\Components\Textarea::make('hotspot_caption_4')
                                            ->label('РљР°СЂС‚РѕС‡РєР° 4: РўРµРєСЃС‚')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 9')
                                            ->rows(2)
                                            ->formatStateUsing(fn ($state, Get $get): ?string => filled($state) ? (string) $state : self::resolveHotspotCaptionByIndex(3, $get('body'))),
                                        Forms\Components\Placeholder::make('save_block_action')
                                            ->label('')
                                            ->content(new HtmlString(
                                                '<div style="padding-top: 8px;">' .
                                                '<button type="submit" style="display:inline-flex;align-items:center;justify-content:center;padding:10px 16px;border:none;border-radius:10px;background:#f59e0b;color:#fff;font-weight:600;cursor:pointer;box-shadow:0 1px 2px rgba(0,0,0,.08);" onmouseover="this.style.background=\'#d97706\'" onmouseout="this.style.background=\'#f59e0b\'">' .
                                                'РЎРѕС…СЂР°РЅРёС‚СЊ' .
                                                '</button>' .
                                                '<button type="button" style="display:inline-flex;align-items:center;justify-content:center;margin-left:10px;padding:10px 16px;border:1px solid #d1d5db;border-radius:10px;background:#fff;color:#374151;font-weight:600;cursor:pointer;" onclick="window.location.reload()">' .
                                                '??????' .
                                                '</button>' .
                                                '</div>'
                                            )),
                                        Forms\Components\Placeholder::make('photo_10_preview')
                                            ->label('Р¤РѕС‚Рѕ')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 10')
                                            ->content(fn (Get $get): HtmlString => self::buildImagePreviewHtml(self::resolveBlockImageByIndex(0, $get('images'), $get('image'), $get('body')))),
                                        Forms\Components\FileUpload::make('image')
                                            ->label('Р—Р°РјРµРЅРёС‚СЊ С„РѕС‚Рѕ')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 10')
                                            ->image()
                                            ->disk('public')
                                            ->directory('files/pages/blocks')
                                            ->visibility('public')
                                            ->imageEditor(),
                                        Forms\Components\Placeholder::make('video_preview')
                                            ->label('Р’РёРґРµРѕ (РїСЂРµРІСЊСЋ)')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 8')
                                            ->content(function (Get $get): HtmlString {
                                                $video = $get('video');
                                                if (!is_string($video) || trim($video) === '') {
                                                    return new HtmlString('<span style="opacity:.7">Р’РёРґРµРѕ РЅРµ Р·Р°РіСЂСѓР¶РµРЅРѕ</span>');
                                                }

                                                $src = str_starts_with($video, 'http://') || str_starts_with($video, 'https://') || str_starts_with($video, '/')
                                                    ? $video
                                                    : asset('storage/' . ltrim($video, '/'));

                                                return new HtmlString(
                                                    '<video controls preload="metadata" style="width: 320px; max-width: 100%; border-radius: 8px; border: 1px solid #ddd;">' .
                                                    '<source src="' . e($src) . '" type="video/mp4">' .
                                                    '</video>'
                                                );
                                            }),
                                        Forms\Components\FileUpload::make('video')
                                            ->label('Р—Р°РіСЂСѓР·РёС‚СЊ РІРёРґРµРѕ MP4')
                                            ->visible(fn (Get $get): bool => trim((string) $get('name')) === 'Р‘Р»РѕРє 8')
                                            ->extraAttributes(['class' => 'block-8-video-upload'])
                                            ->disk('public')
                                            ->directory('files/pages/blocks/videos')
                                            ->visibility('public')
                                            ->acceptedFileTypes(['video/mp4', 'video/quicktime', 'video/x-m4v', 'application/octet-stream'])
                                            ->maxSize(102400)
                                            ->saveUploadedFileUsing(function ($file): string {
                                                if (is_object($file) && method_exists($file, 'storePublicly')) {
                                                    return $file->storePublicly('files/pages/blocks/videos', 'public');
                                                }
                                                if (is_object($file) && method_exists($file, 'store')) {
                                                    return $file->store('files/pages/blocks/videos', 'public');
                                                }

                                                return (string) $file;
                                            })
                                            ->helperText(new HtmlString(
                                                'Upload MP4. Video will be shown in block 8.' .
                                                '<style>.block-8-video-upload .filepond--drop-label{display:none !important;}</style>'
                                            )),
                                    ])
                                    ->defaultItems(0)
                                    ->addable(false)
                                    ->reorderableWithButtons()
                                    ->collapsible()
                                    ->collapsed(),

                                Forms\Components\FileUpload::make('attachments')
                                    ->multiple()
                                    ->label('Р¤Р°Р№Р»С‹')
                                    ->imageEditor()
                                    ->appendFiles()
                                    ->openable()
                                    ->directory('/files/pages'),
                            ]),

                        Forms\Components\Tabs\Tab::make('РњРµС‚Р° РёРЅС„РѕСЂРјР°С†РёСЏ')
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
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('РќР°Р·РІР°РЅРёРµ')
                    ->sortable()
                    ->searchable(['title', 'slug']),
                Tables\Columns\TextColumn::make('slug')->label('РЇСЂР»С‹Рє')
                    ->sortable()
                    ->getStateUsing(function (Page $page) {
                        return '/' . $page->slug;
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->label(__('fields.created_at'))->dateTime('d.m.Y H:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->label(__('fields.updated_at'))->dateTime('d.m.Y H:i'),
                Tables\Columns\ToggleColumn::make('is_active')->label(__('fields.is_active')),
            ])
            ->filters([
                //
            ])
            ->defaultSort('updated_at', 'desc')
            ->actions([
                Tables\Actions\Action::make('site_url')
                    ->label('РќР° СЃР°Р№С‚ в†’')
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    private static function buildImagePreviewHtml(?string $src): HtmlString
    {
        if (empty($src)) {
            return new HtmlString('<span style="opacity:.7">РќРµС‚ С„РѕС‚Рѕ</span>');
        }

        return new HtmlString(
            '<img src="' . e($src) . '" style="width: 220px; height: 130px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;" />'
        );
    }

    private static function resolveBlockImageByIndex(
        int $index,
        string|array|null $images,
        string|array|null $legacyImage,
        ?string $body
    ): ?string {
        $sources = self::resolveBlockImageSrcs($images, $legacyImage, $body);

        return $sources[$index] ?? null;
    }

    private static function resolveBlockImageSrcs(
        string|array|null $images,
        string|array|null $legacyImage,
        ?string $body
    ): array {
        $normalized = [];

        foreach ([$images, $legacyImage] as $value) {
            if (is_array($value)) {
                foreach ($value as $item) {
                    if (is_string($item) && $item !== '') {
                        $normalized[] = $item;
                    }
                }
                continue;
            }

            if (is_object($value) && method_exists($value, 'getRealPath')) {
                continue;
            }

            if (is_string($value) && $value !== '') {
                $normalized[] = $value;
            }
        }

        $normalized = array_values(array_unique($normalized));

        if (count($normalized) > 0) {
            return array_map(function (string $image): string {
                if (
                    str_starts_with($image, 'http://') ||
                    str_starts_with($image, 'https://') ||
                    str_starts_with($image, '/')
                ) {
                    return $image;
                }

                return asset('storage/' . ltrim($image, '/'));
            }, $normalized);
        }

        if (!empty($body)) {
            $found = [];
            $isPhoto = static function (string $src): bool {
                return (bool) preg_match('/\.(jpe?g|png|webp|gif)(\?.*)?$/i', $src);
            };

            if (preg_match_all('/background-image\\s*:\\s*url\\((["\\\']?)([^)\\\"\\\']+)\\1\\)/i', $body, $bg)) {
                foreach (($bg[2] ?? []) as $src) {
                    $src = trim(html_entity_decode((string) $src, ENT_QUOTES | ENT_HTML5));
                    if ($src !== '' && $isPhoto($src)) {
                        $found[] = $src;
                    }
                }
            }

            if (preg_match_all('/<img[^>]*src=["\\\']([^"\\\']+)["\\\']/i', $body, $img)) {
                foreach (($img[1] ?? []) as $src) {
                    $src = trim(html_entity_decode((string) $src, ENT_QUOTES | ENT_HTML5));
                    if ($src !== '' && $isPhoto($src)) {
                        $found[] = $src;
                    }
                }
            }

            return array_values(array_unique($found));
        }

        return [];
    }

    private static function resolveHotspotImageByIndex(int $index, ?string $body): ?string
    {
        if (empty($body)) {
            return null;
        }

        if (!preg_match_all('/data-hotspot-button[^>]*data-image=["\\\']([^"\\\']+)["\\\']/i', $body, $m)) {
            return null;
        }

        $src = $m[1][$index] ?? null;
        if (!is_string($src) || trim($src) === '') {
            return null;
        }

        if (
            str_starts_with($src, 'http://') ||
            str_starts_with($src, 'https://') ||
            str_starts_with($src, '/')
        ) {
            return $src;
        }

        return asset('storage/' . ltrim($src, '/'));
    }

    private static function resolveHotspotCaptionByIndex(int $index, ?string $body): ?string
    {
        if (empty($body)) {
            return null;
        }

        if (!preg_match_all('/data-hotspot-button[^>]*data-caption=["\\\']([^"\\\']+)["\\\']/i', $body, $m)) {
            return null;
        }

        $caption = $m[1][$index] ?? null;
        if (!is_string($caption) || trim($caption) === '') {
            return null;
        }

        return html_entity_decode($caption, ENT_QUOTES | ENT_HTML5);
    }
}

