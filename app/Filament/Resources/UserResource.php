<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    public static function can(string $action, ?Model $record = null): bool
    {
        return auth()->user()->is_admin;
    }

    protected static ?string $model = User::class;
    protected static ?string $modelLabel = 'Пользователь';
    protected static ?string $pluralLabel = 'Пользователи';
    protected static ?string $navigationIcon = 'heroicon-s-user';

    public static function getNavigationLabel(): string
    {
        return 'Users';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->autocomplete(false)
                    ->label('Имя')
                    ->required()->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->autocomplete(false)
                    ->label('E-mail')
                    ->required()
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->autocomplete(false)
                    ->label('Пароль')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                Forms\Components\Checkbox::make('is_admin')
                    ->label('Администратор')
                    ->helperText('Снимайте эту галочку только если в системе есть другой администратор.')
                ->rules([
                    fn($get) => function (string $attribute, $value, $fail) use ($get) {
                        $authUserId = $get('id');
                        $currentUserId = $get('id');
                        if ($value === false
                            && $authUserId !== null
                            && $authUserId === $currentUserId) {
                            $fail("Нельзя снять права администратора у текущего пользователя.");
                        }
                    },
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Имя')->sortable(),
                Tables\Columns\TextColumn::make('email')->label('E-mail')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Создан')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->label('Обновлен')->sortable(),
                Tables\Columns\IconColumn::make('is_admin')->label('Администратор')->boolean(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
