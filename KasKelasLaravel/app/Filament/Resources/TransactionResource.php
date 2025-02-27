<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Manajemen Data Keuangan';

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?string $pluralLabel = 'Data Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Select::make('student_id')
                    ->relationship('student', 'name')
                    ->required()
                    ->label('Nama Siswa')
                    ->placeholder('Pilih Nama Siswa'),

                TextInput::make('amount')
                    ->placeholder('Masukkan jumlah transaksi')
                    ->label('Jumlah')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->prefix('IDR'),

                TextInput::make('description')
                    ->placeholder('Masukkan keterangan transaksi')
                    ->label('Keterangan')
                    ->required()
                    ->maxLength(255),

                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required(),

                Select::make('type')
                    ->placeholder('Pilih Tipe Transaksi')
                    ->label('Tipe Transaksi')
                    ->options([
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('student.name')
                    ->sortable(),

                TextColumn::make('amount')
                    ->money('IDR') // Menyesuaikan dengan Rupiah
                    ->sortable(),


                TextColumn::make('description'),

                TextColumn::make('date')
                    ->date('d M Y') // Contoh: 21 Okt 2024
                    ->sortable(),


                TextColumn::make('type'),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
