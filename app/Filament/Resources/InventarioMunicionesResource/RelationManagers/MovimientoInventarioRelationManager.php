<?php

namespace App\Filament\Resources\InventarioMunicionesResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CatalogoInventario;
use App\Models\InventarioMuniciones;
use App\Models\Aerodromo;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;


class MovimientoInventarioRelationManager extends RelationManager
{
    protected static string $relationship = 'movimientos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Select::make('aerodromo_id')
                //     ->label('Aeródromo')
                //     ->options(Aerodromo::pluck('nombre', 'id'))
                //     ->required(),

                // Forms\Components\Select::make('catinventario_id')
                //     ->label('Equipo')
                //     ->options(CatalogoInventario::pluck('nombre', 'id'))
                //     ->required(),

                // Forms\Components\Select::make('user_id')
                //     ->label('Usuario')
                //     ->options(User::pluck('name', 'id'))
                //     ->required(),

                // Forms\Components\Select::make('tipo_movimiento')
                //     ->label('Tipo de Movimiento')
                //     ->options([
                //         'Entrada' => 'Entrada',
                //         'Salida' => 'Salida',
                //     ])
                //     ->required(),

                // Forms\Components\TextInput::make('cantidad_usar')
                //     ->label('Cantidad del Movimiento')
                //     ->numeric()
                //     ->required(),
                Select::make('aerodromo_id')
            ->label('Aeródromo')
            ->options(Aerodromo::pluck('nombre', 'id'))
            ->required()
            ->reactive()
            ->afterStateUpdated(fn (callable $set) => $set('catinventario_id', null)),

        Select::make('catinventario_id')
            ->label('Equipo')
            ->options(CatalogoInventario::pluck('nombre', 'id'))
            ->required()
            ->reactive(),

        // Mostrar el stock actual en tiempo real
        Placeholder::make('stock_actual')
            ->label('Stock disponible')
            ->content(function ($get) {
                $stock = \App\Models\InventarioMuniciones::where('aerodromo_id', $get('aerodromo_id'))
                    ->where('catinventario_id', $get('catinventario_id'))
                    ->first()?->cantidad_actual ?? 'No disponible';
                return $stock;
            }),

        Select::make('tipo_movimiento')
            ->options([
                'Entrada' => 'Entrada',
                'Salida' => 'Salida',
            ])
            ->required(),
Forms\Components\Select::make('user_id')
                ->label('Usuario')
                ->options(User::pluck('name', 'id'))
                ->required(),
        TextInput::make('cantidad_usar')
            ->label('Cantidad del movimiento')
            ->numeric()
            ->required()
            ->rule(function ($get) {
                if ($get('tipo_movimiento') === 'Salida') {
                    $stock = \App\Models\InventarioMuniciones::where('aerodromo_id', $get('aerodromo_id'))
                        ->where('catinventario_id', $get('catinventario_id'))
                        ->first()?->cantidad_actual ?? 0;

                    return "max:$stock";
                }
                return null;
            }),
            ]);

    }

    public  function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('aerodromo.nombre')->label('Aeródromo')->searchable(),
                Tables\Columns\TextColumn::make('catalogoInventario.nombre')->label('Equipo')->searchable(),
                Tables\Columns\TextColumn::make('tipo_movimiento')->label('Tipo de Movimiento'),
                Tables\Columns\TextColumn::make('cantidad_usar')->label('Cantidad Usada'),
                Tables\Columns\TextColumn::make('stock_actual')
                    ->label('Stock Disponible')
                    ->getStateUsing(function ($record) {
                        $inventario = InventarioMuniciones::where('aerodromo_id', $record->aerodromo_id)
                            ->where('catinventario_id', $record->catinventario_id)
                            ->first();
                        return $inventario ? $inventario->cantidad_actual : 0;
                    }),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->label('Fecha y Hora')
                //     ->dateTime('d/m/Y H:i')
                //     ->sortable(),
               Tables\Columns\TextColumn::make('user.name')->label('Persona')->searchable(),


            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Nuevo Movimiento'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
