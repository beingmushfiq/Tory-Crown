<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->searchable(),
                TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('customer_name')
                    ->searchable(),
                TextColumn::make('customer_email')
                    ->searchable(),
                TextColumn::make('customer_phone')
                    ->searchable(),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('subtotal')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('vat_total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('shipping_charge')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('discount_total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('grand_total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('partial_advance')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('payment_method')
                    ->searchable(),
                TextColumn::make('payment_status')
                    ->searchable(),
                TextColumn::make('order_status')
                    ->searchable(),
                TextColumn::make('courier_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        'returned' => 'danger',
                        'in_transit' => 'info',
                        default => 'gray',
                    })
                    ->searchable(),
                TextColumn::make('consignment_id')
                    ->searchable(),
                TextColumn::make('tracking_url')
                    ->searchable(),
                TextColumn::make('event_id')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                \Filament\Tables\Actions\Action::make('dispatch')
                    ->label('Dispatch')
                    ->icon('heroicon-o-truck')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Dispatch to Steadfast')
                    ->modalDescription('Are you sure you want to send this order to Steadfast Courier?')
                    ->visible(fn ($record) => empty($record->consignment_id))
                    ->action(function ($record) {
                        $courierService = app(\App\Services\CourierService::class);
                        $result = $courierService->createSteadfastOrder($record);
                        
                        if ($result['success']) {
                            \Filament\Notifications\Notification::make()
                                ->title('Dispatched')
                                ->success()
                                ->body($result['message'])
                                ->send();
                        } else {
                            \Filament\Notifications\Notification::make()
                                ->title('Dispatch Failed')
                                ->danger()
                                ->body($result['message'])
                                ->send();
                        }
                    }),
                \Filament\Tables\Actions\Action::make('sync_status')
                    ->label('Sync Status')
                    ->icon('heroicon-o-arrow-path')
                    ->color('info')
                    ->visible(fn ($record) => !empty($record->consignment_id))
                    ->action(function ($record) {
                        $courierService = app(\App\Services\CourierService::class);
                        $result = $courierService->checkSteadfastStatus($record);
                        
                        if ($result['success']) {
                            \Filament\Notifications\Notification::make()
                                ->title('Status Updated')
                                ->success()
                                ->body($result['message'])
                                ->send();
                        } else {
                            \Filament\Notifications\Notification::make()
                                ->title('Sync Failed')
                                ->danger()
                                ->body($result['message'])
                                ->send();
                        }
                    }),
                \Filament\Tables\Actions\Action::make('track')
                    ->label('Track')
                    ->icon('heroicon-o-magnifying-glass')
                    ->color('gray')
                    ->url(fn ($record) => $record->tracking_url)
                    ->openUrlInNewTab()
                    ->visible(fn ($record) => !empty($record->tracking_url)),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    \Filament\Tables\Actions\BulkAction::make('bulk_dispatch')
                        ->label('Bulk Dispatch to Steadfast')
                        ->icon('heroicon-o-truck')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function (\Illuminate\Support\Collection $records) {
                            $courierService = app(\App\Services\CourierService::class);
                            $successCount = 0;
                            $failCount = 0;

                            foreach ($records as $record) {
                                if (empty($record->consignment_id)) {
                                    $result = $courierService->createSteadfastOrder($record);
                                    if ($result['success']) {
                                        $successCount++;
                                    } else {
                                        $failCount++;
                                    }
                                }
                            }

                            \Filament\Notifications\Notification::make()
                                ->title('Bulk Dispatch Finished')
                                ->success()
                                ->body("Successfully dispatched {$successCount} orders. Failed: {$failCount}")
                                ->send();
                        }),
                ]),
            ]);
    }
}
