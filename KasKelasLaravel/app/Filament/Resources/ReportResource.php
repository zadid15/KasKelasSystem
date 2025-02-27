<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\RelationManagers;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';

    protected static ?string $navigationLabel = 'Laporan';

    protected static ?string $pluralLabel = 'Data Laporan Keuangan';

    protected static ?string $navigationGroup = 'Manajemen Data Laporan Keuangan';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('month')
                ->placeholder('Masukkan Bulan Saat Laporan Dibuat.')
                ->numeric()
                ->required()
                ->minValue(1)
                ->maxValue(12)
                ->label('Bulan'),

            TextInput::make('year')
                ->placeholder('Masukkan Tahun Saat Laporan Dibuat.')
                ->numeric()
                ->required()
                ->minValue(2024)
                ->maxValue(date('Y'))
                ->label('Tahun'),

            TextInput::make('total_income')
                ->placeholder('Masukkan Total Masuk Uang Saat Laporan Dibuat.')
                ->numeric()
                ->required()
                ->prefix('IDR')
                ->label('Total Masuk'),

            TextInput::make('total_expense')
                ->placeholder('Masukkan Total Keluar Uang Saat Laporan Dibuat.')
                ->numeric()
                ->required()
                ->prefix('IDR')
                ->label('Total Keluar'),

            TextInput::make('balance')
                ->placeholder('Masukkan Saldo Saat Laporan Dibuat.')
                ->numeric()
                ->required()
                ->prefix('IDR')
                ->label('Saldo'),
        ]);
}


public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('month')
                ->sortable()
                ->searchable()
                ->label('Bulan'),

            TextColumn::make('year')
                ->sortable()
                ->searchable()
                ->label('Tahun'),

            TextColumn::make('total_income')
                ->sortable()
                ->money('IDR')
                ->label('Total Masuk'),

            TextColumn::make('total_expense')
                ->sortable()
                ->money('IDR')
                ->label('Total Keluar'),

            TextColumn::make('balance')
                ->sortable()
                ->money('IDR')
                ->label('Saldo'),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('month')
                ->options([
                    '1' => 'January',
                    '2' => 'February',
                    '3' => 'March',
                    '4' => 'April',
                    '5' => 'May',
                    '6' => 'June',
                    '7' => 'July',
                    '8' => 'August',
                    '9' => 'September',
                    '10' => 'October',
                    '11' => 'November',
                    '12' => 'December',
                ])
                ->label('Filter by Month'),
        
            Tables\Filters\SelectFilter::make('year')
                ->options(fn () => range(date('Y'), 2024)) // Dari tahun sekarang ke 2000
                ->label('Filter by Year'),
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
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
