<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_number')->disabled(),
                Select::make('order_status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ])->required(),
                TextInput::make('customer_name')->required(),
                TextInput::make('customer_email')->email()->required(),
                TextInput::make('customer_phone')->tel()->required(),
                TextInput::make('city')->required(),
                Textarea::make('shipping_address')->required()->columnSpanFull(),
                
                Section::make('Financials')
                    ->schema([
                        TextInput::make('subtotal')->numeric()->required()->prefix('BDT'),
                        TextInput::make('vat_total')->numeric()->required()->prefix('BDT'),
                        TextInput::make('shipping_charge')->numeric()->required()->prefix('BDT'),
                        TextInput::make('grand_total')->numeric()->required()->prefix('BDT'),
                        TextInput::make('partial_advance')->numeric()->required()->prefix('BDT'),
                    ])->columns(2),

                Section::make('Payment & Logistics')
                    ->schema([
                        Select::make('payment_method')
                            ->options([
                                'cod' => 'Cash on Delivery',
                                'bkash' => 'bKash',
                                'nagad' => 'Nagad',
                                'sslcommerz' => 'SSLCommerz',
                            ])->required(),
                        Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                                'refunded' => 'Refunded',
                            ])->required(),
                        TextInput::make('courier_status')->disabled(),
                        TextInput::make('consignment_id')->disabled(),
                        TextInput::make('tracking_url')->url()->disabled(),
                    ])->columns(2),

                Repeater::make('items')
                    ->relationship()
                    ->schema([
                        TextInput::make('product_name')->required(),
                        TextInput::make('variant_sku')->required(),
                        TextInput::make('quantity')->numeric()->required(),
                        TextInput::make('unit_price')->numeric()->required()->prefix('BDT'),
                        TextInput::make('weight')->numeric()->required()->suffix('g'),
                    ])->columnSpanFull()->columns(5)->disabled(),
            ]);
    }
}
