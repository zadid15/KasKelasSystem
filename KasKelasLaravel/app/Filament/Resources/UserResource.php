<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Manajemen Data Users';

    protected static ?string $navigationLabel = 'Users';

    protected static ?string $pluralLabel = 'Data Users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('student_id')
                    ->relationship('student', 'name')
                    ->searchable()
                    ->placeholder('Select a student')
                    ->nullable(),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter full name')
                    ->nullable(),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Enter email address'),

                TextInput::make('password')
                    ->password()
                    ->required()
                    ->placeholder('Enter password')
                    ->dehydrateStateUsing(fn($state) => Hash::make($state)) // Hashing password sebelum disimpan
                    ->required(fn(string $context): bool => $context === 'create'), // Hanya required saat create

                Select::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'student' => 'Student',
                        'treasurer' => 'Treasurer',
                    ])
                    ->required()
                    ->placeholder('Select role'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('role')
                ->label('Role')
                ->formatStateUsing(fn(string|int|null $state): string => match ($state) {
                    'admin' => 'Admin',
                    'treasurer' => 'Treasurer',
                    'student' => 'Student',
                })
                ->badge()
                ->colors([
                    'info' => 'admin',
                    'success' => 'student',
                    'warning' => 'treasurer',
                ]),
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
