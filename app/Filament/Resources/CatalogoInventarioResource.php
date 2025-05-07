<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatalogoInventarioResource\Pages;
use App\Filament\Resources\CatalogoInventarioResource\RelationManagers;
use App\Models\CatalogoInventario;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Acciones;


class CatalogoInventarioResource extends Resource
{
    protected static ?string $model = CatalogoInventario::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?string $navigationGroup = 'Catálogos';
    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('acciones_id')
                ->label('Acción')
                ->options(Acciones::all()->pluck('nombre', 'id'))
                ->searchable()
                ->required(),

                Forms\Components\TextInput::make('nombre')
                ->label('Nombre del equipo')
                ->required()
                ->maxLength(20),

                Forms\Components\Select::make('consumible')
                    ->label('Consumible')
                    ->options([
                        1 => 'Si',
                        0 => 'No',
                    ]),
                Forms\Components\TextInput::make('descripcion')
                    ->label('Descripción del equipo')
                    ->required()
                    ->maxLength(200),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                ->searchable(),
                Tables\Columns\IconColumn::make('consumible')
                ->label('Activo'),
                Tables\Columns\TextColumn::make('descripcion')
                ->searchable(),
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
            'index' => Pages\ListCatalogoInventarios::route('/'),
            'create' => Pages\CreateCatalogoInventario::route('/create'),
            'edit' => Pages\EditCatalogoInventario::route('/{record}/edit'),
        ];
    }
}
