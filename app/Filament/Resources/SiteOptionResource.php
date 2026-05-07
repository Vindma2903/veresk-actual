<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteOptionResource\Pages;
use App\Models\SiteOption;
use Creagia\FilamentCodeField\CodeField;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use InvadersXX\FilamentJsoneditor\Forms\JSONEditor;

class SiteOptionResource extends Resource
{
    protected static ?string $model = SiteOption::class;
    protected static ?string $modelLabel = 'Настройка сайта';
    protected static ?string $pluralLabel = 'Настройки сайта';
    protected static ?string $navigationIcon = 'heroicon-s-cog';

    public static function getNavigationLabel(): string
    {
        return 'Settings';
    }

    public static function form(Form $form): Form
    {
        $formSchema = [
            Forms\Components\TextInput::make('id')->label(__('fields.id'))->disabledOn('edit'),
            Forms\Components\TextInput::make('type')->label(__('fields.type'))->disabledOn('edit'),
            Forms\Components\TextInput::make('title')
                ->label(__('fields.title'))
                ->maxLength(255)
                ->required()
                ->disabledOn('edit')
            ,
            Forms\Components\Textarea::make('description')
                ->label(__('fields.description'))
                ->disabledOn('edit')
        ];

        if ($form->getOperation() === 'edit' && $form->model instanceof SiteOption) {
            switch ($form->model->type) {
                case SiteOption::BODY_TYPE_JSON:
                    $bodyField = JSONEditor::make('body_json')->height(500)->modes(['code'])
                        ->afterStateHydrated(function (?array $state, JSONEditor $component): void {
                            $component->state(json_encode($state, JSON_PRETTY_PRINT));
                        })
                    ;
                    break;
                case SiteOption::BODY_TYPE_EMAIL:
                    $bodyField = Forms\Components\TextInput::make('body')->email();
                    break;
                case SiteOption::BODY_TYPE_HTML:
                    $bodyField = CodeField::make('body')->htmlField()->withLineNumbers();
                    break;
                default:
                    $bodyField = Forms\Components\TextInput::make('body');
            }

            $formSchema[] = $bodyField->label(__('fields.body'))->columnSpanFull();
        }


        return $form
            ->schema($formSchema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('fields.id'))->sortable(),
                Tables\Columns\TextColumn::make('title')->label(__('fields.title'))
                    ->sortable()
                    ->searchable(['title', 'description', 'id'])
                ,
                Tables\Columns\TextColumn::make('description')->label(__('fields.description')),
                Tables\Columns\TextColumn::make('type')->label(__('fields.type'))->sortable(),
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
            'index' => Pages\ListSiteOptions::route('/'),
            'create' => Pages\CreateSiteOption::route('/create'),
            'edit' => Pages\EditSiteOption::route('/{record}/edit'),
        ];
    }
}
