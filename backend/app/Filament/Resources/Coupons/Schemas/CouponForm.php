<?php

namespace App\Filament\Resources\Coupons\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CouponForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required()
                    ->unique(ignoreRecord: true),
                \Filament\Forms\Components\Select::make('type')
                    ->options([
                        'fixed' => 'Fixed Amount',
                        'percentage' => 'Percentage',
                    ])
                    ->required(),
                TextInput::make('value')
                    ->required()
                    ->numeric()
                    ->helperText('Amount or Percentage value'),
                TextInput::make('min_order_amount')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->prefix('৳'),
                TextInput::make('usage_limit')
                    ->numeric()
                    ->helperText('Leave empty for unlimited usage'),
                TextInput::make('used_count')
                    ->numeric()
                    ->disabled()
                    ->default(0),
                \Filament\Forms\Components\DateTimePicker::make('starts_at'),
                \Filament\Forms\Components\DateTimePicker::make('expires_at'),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}
