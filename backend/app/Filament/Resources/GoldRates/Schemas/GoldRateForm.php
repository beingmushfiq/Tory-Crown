<?php

namespace App\Filament\Resources\GoldRates\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GoldRateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('karat')
                    ->options([
                        '18K' => '18K',
                        '21K' => '21K',
                        '22K' => '22K',
                        '24K' => '24K',
                    ])
                    ->required(),
                TextInput::make('price_per_gram')
                    ->required()
                    ->numeric()
                    ->prefix('৳')
                    ->helperText('Current gold price per gram in BDT'),
                \Filament\Forms\Components\DateTimePicker::make('effective_date')
                    ->required()
                    ->default(now()),
            ]);
    }
}
