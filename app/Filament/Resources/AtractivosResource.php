<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AtractivosResource\Pages;
use App\Filament\Resources\AtractivosResource\RelationManagers;
use App\Models\Atractivo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AtractivosResource extends Resource
{
    protected static ?string $model = Atractivo::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Catálogos';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('nombre')
                ->label('Atractivo para la fauna')
                ->options([
                    'Vertederos de basura',
                    'Fuentes de agua estancada',
                    'Cultivos cercanos',
                    'Presencia de insectos',
                    'Lagunas o riós',
                    'Áreas de vegetación densa',
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->label('Tipo de Atractivo')->searchable()->sortable(),
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
            'index' => Pages\ListAtractivos::route('/'),
            'create' => Pages\CreateAtractivos::route('/create'),
            'edit' => Pages\EditAtractivos::route('/{record}/edit'),
        ];
    }
}
