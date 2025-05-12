<?php

namespace App\Filament\Resources\InventarioMunicionesResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CatalogoInventario;
use App\Models\InventarioMuniciones;
use App\Models\MovimientoInventario;
use App\Models\Aerodromo;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\NativeSelect;
use Filament\Notifications\Notification;

class MovimientoInventarioRelationManager extends RelationManager
{
    protected static string $relationship = 'movimientos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('catalogoInventario.nombre')->label('Equipo')->searchable(), //Catalogo de Inventario

                Tables\Columns\TextColumn::make('tipo_movimiento')->label('Tipo de Movimiento'), //Tipo de Movimiento

                Tables\Columns\TextColumn::make('cantidad_usar')->label('Cantidad'), // Cantidad a usar

                Tables\Columns\TextColumn::make('stock_actual')
                    ->label('Stock Disponible')                                      //Stock Actual
                    ->getStateUsing(function ($record) {
                        $inventario = InventarioMuniciones::where('aerodromo_id', $record->aerodromo_id)
                            ->where('catinventario_id', $record->catinventario_id)
                            ->first();
                        return $inventario ? $inventario->cantidad_actual : 0;
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha y Hora')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')->label('Responsable')->searchable(), //Responsable
            ])
            ->headerActions([
                Tables\Actions\Action::make('entrada')
                    ->label('🟢 Entrada')
                    ->form([
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

                        Placeholder::make('stock_actual')
                            ->label('Stock disponible')
                            ->content(function ($get) {
                                return InventarioMuniciones::where('aerodromo_id', $get('aerodromo_id'))
                                    ->where('catinventario_id', $get('catinventario_id'))
                                    ->first()?->cantidad_actual ?? 'No disponible';
                            }),

                        Select::make('tipo_movimiento')
                            ->label('Tipo de Movimiento')
                            ->options([
                                'Compra' => '🟢 Entrada - Compra',
                                'Donacion' => '🟢 Entrada - Donación',
                            ])
                            ->required(),

                        Select::make('user_id')
                            ->label('Usuario')
                            ->options(User::pluck('name', 'id'))
                            ->required(),

                        TextInput::make('cantidad_usar')
                            ->label('Cantidad del movimiento')
                            ->numeric()
                            ->required(),

                        Textarea::make('comentario')
                            ->label('Comentario')
                            ->maxLength(255),
                    ])
                    ->action(function (array $data) {
                        $result = MovimientoInventario::create($data);

                        if ($result['success']) {
                            Notification::make()
                                ->title('Entrada registrada correctamente')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Error al registrar la entrada')
                                ->body($result['message'])
                                ->danger()
                                ->send();
                        }
                    }),

                Tables\Actions\Action::make('salida')
                    ->label('🔴 Salida')
                    ->form([
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

                        Placeholder::make('stock_actual')
                            ->label('Stock disponible')
                            ->content(function ($get) {
                                return InventarioMuniciones::where('aerodromo_id', $get('aerodromo_id'))
                                    ->where('catinventario_id', $get('catinventario_id'))
                                    ->first()?->cantidad_actual ?? 'No disponible';
                            }),

                        Select::make('tipo_movimiento')
                            ->label('Tipo de Movimiento')
                            ->options([
                                'Consumo' => '🔴 Salida - Consumo',
                                'Baja' => '🔴 Salida - Baja',
                            ])
                            ->required(),

                        Select::make('user_id')
                            ->label('Usuario')
                            ->options(User::pluck('name', 'id'))
                            ->required(),

                        TextInput::make('cantidad_usar')
                            ->label('Cantidad del movimiento')
                            ->numeric()
                            ->required(),

                        Textarea::make('comentario')
                            ->label('Comentario')
                            ->maxLength(255),
                    ])
                    ->action(function (array $data) {
                        $result = MovimientoInventario::create($data);

                        if ($result['success']) {
                            Notification::make()
                                ->title('Salida registrada correctamente')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Error al registrar la salida')
                                ->body($result['message'])
                                ->danger()
                                ->send();
                        }
                    })
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
