<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovimientoInventarioResource\Pages;
use App\Models\MovimientoInventario;
use App\Models\CatalogoInventario;
use App\Models\InventarioMuniciones;
use App\Models\Aerodromo;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;


class MovimientoInventarioResource extends Resource
{
    protected static ?string $model = MovimientoInventario::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
        Forms\Components\Select::make('aerodromo_id')
            ->label('Aeródromo')
            ->options(Aerodromo::pluck('nombre', 'id'))
            ->required(),

        Forms\Components\Select::make('catinventario_id')
            ->label('Equipo')
            ->options(CatalogoInventario::pluck('nombre', 'id'))
            ->required(),
        Forms\Components\Select::make('user_id')
            ->label('Usuario')
            ->options(User::pluck('name', 'id'))
            ->required(),

        Forms\Components\Select::make('tipo_movimiento')
            ->options([
                'Entrada' => 'Entrada',
                'Salida' => 'Salida',
            ])
            ->required(),

        Forms\Components\TextInput::make('cantidad_usar')
            ->label('Cantidad del movimiento')
            ->maxLength(50)
            ->required()
            ]);

    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               Tables\Columns\TextColumn::make('aerodromo.nombre')->label('Aeródromo')
                ->searchable(),
            Tables\Columns\TextColumn::make('catalogoInventario.nombre')->label('Equipo')
                ->searchable(),
            Tables\Columns\TextColumn::make('tipo_movimiento')->label('Tipo de Movimiento'),
            // Columna que muestra el stock disponible
            Tables\Columns\TextColumn::make('stock_actual')
                ->label('Stock Disponible')
                ->getStateUsing(function ($record) {
                    // Aquí se obtiene el stock actual en Inventario
                    $inventario = InventarioMuniciones::where('aerodromo_id', $record->aerodromo_id)
                        ->where('catinventario_id', $record->catinventario_id)
                        ->first();
                    return $inventario ? $inventario->cantidad_actual : 0;
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Reemplazamos EditAction por una acción personalizada con modal
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListMovimientoInventarios::route('/'),
            'create' => Pages\CreateMovimientoInventario::route('/create'),
            'edit' => Pages\EditMovimientoInventario::route('/{record}/edit'),
        ];
    }
}
