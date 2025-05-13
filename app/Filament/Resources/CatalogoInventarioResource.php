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
    protected static ?string $navigationLabel = "Catálogo de Inventario";
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

                Forms\Components\Select::make('nombre')
                ->label('Equipo')
                ->placeholder('Eliga el equipo')
                ->options(CatalogoInventario::all()->pluck('nombre','id'))
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('categoria_equipo')
                    ->label('Tipo de Equipo')
                    ->options([
                        'Armas' => 'Armas',
                        'Municiones' => 'Municiones',
                        'Instrumento' => 'Instrumento',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('descripcion')
                    ->label('Descripción del equipo')
                    ->required()
                    ->maxLength(200),
                Forms\Components\Select::make('estado')
                    ->label('Estado')
                    ->options([
                        1 => 'Activo',
                        0 => 'Inactivo',
                    ])
                    ->default(1) // Valor por defecto establecido como "Activo"
                    ->required(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')->label('Nombre Herramienta')
                ->searchable(),
                Tables\Columns\TextColumn::make('descripcion')
                ->searchable(),
                Tables\Columns\TextColumn::make('cantidad_stock')
                ->searchable(),
                Tables\Columns\IconColumn::make('estado')
                    ->label('Activo')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle') // Ícono para verdadero
                    ->falseIcon('heroicon-o-x-circle') // Ícono para falso
                    ->trueColor('success') // Color para verdadero
                    ->falseColor('danger'), // Color para falso
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([

                    Tables\Actions\DeleteBulkAction::make(),

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
