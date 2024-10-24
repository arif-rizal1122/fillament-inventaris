<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Category;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Jenis/Category')
                    ->required(),
                    // ->numeric(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Keperluan')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date')
                    ->label('tanggal')
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->label('total pemasukan / pengeluaran'),
                    // ->sortable(),
                Forms\Components\TextInput::make('note')
                    ->maxLength(255)
                    ->label('catatan')
                    ->default(null),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->label('gambar')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('category.image')
                    ->label('Jenis/Category')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->description(fn (Transaction $record): string => $record->name)
                    ->searchable()
                    ->label('Transaksi'),
                Tables\Columns\IconColumn::make('category.is_expense')
                    ->boolean()
                    ->trueIcon('heroicon-o-chat-bubble-bottom-center-text')
                    ->trueColor('success')
                    ->falseIcon('heroicon-o-chat-bubble-bottom-center')
                    ->falseColor('warning')
                    ->label('tipe'),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->label('tanggal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->money('IDR', locale: 'id')
                    ->label('total')
                    ->sortable(),
                Tables\Columns\TextColumn::make('note')
                    ->label('catatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            // 'index' => Pages\ListTransactions::route('/'),
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit')
        ];
    }
}
