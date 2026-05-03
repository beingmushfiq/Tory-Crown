<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Section::make('General Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('slug', Str::slug($state));
                                $set('meta_title', $state . ' | Tory Crown');
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Automatically generated from name.'),
                        Textarea::make('description')
                            ->columnSpanFull()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('meta_description', Str::limit(strip_tags($state), 160));
                            }),
                    ])->columns(2),

                \Filament\Forms\Components\Section::make('Search Engine Optimization (SEO)')
                    ->description('Optimize how this product appears in search engines like Google.')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->placeholder('Product Name | Tory Crown')
                            ->maxLength(60),
                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->placeholder('A brief summary of the product for search results...')
                            ->maxLength(160)
                            ->columnSpanFull(),
                        TextInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->placeholder('jewelry, gold, necklace, tory crown'),
                    ])->columns(2),

                \Filament\Forms\Components\Section::make('Categorization & Marketing')
                    ->schema([
                        TextInput::make('category'),
                        TextInput::make('collection'),
                        TextInput::make('vat_percentage')
                            ->numeric()
                            ->default(5)
                            ->suffix('%'),
                        \Filament\Forms\Components\Group::make([
                            Toggle::make('is_active')
                                ->default(true),
                            Toggle::make('is_featured')
                                ->default(false),
                        ])->columns(2),
                    ])->columns(2),

                \Filament\Forms\Components\Section::make('Media')
                    ->schema([
                        \Filament\Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                            ->collection('products')
                            ->multiple()
                            ->reorderable()
                            ->responsiveImages()
                            ->conversion('thumb')
                            ->columnSpanFull(),
                    ]),
                
                \Filament\Forms\Components\Section::make('Jewelry Variants & Inventory')
                    ->description('Manage different weights, karats, and stock levels.')
                    ->schema([
                        Repeater::make('variants')
                            ->relationship()
                            ->schema([
                                TextInput::make('sku')->required()->unique(ignoreRecord: true),
                                Select::make('karat')
                                    ->options([
                                        '18K' => '18K',
                                        '21K' => '21K',
                                        '22K' => '22K',
                                        '24K' => '24K',
                                    ])->required(),
                                TextInput::make('weight_in_grams')
                                    ->numeric()
                                    ->required()
                                    ->suffix('g')
                                    ->helperText('Weight used for dynamic pricing'),
                                TextInput::make('size'),
                                TextInput::make('making_charge')
                                    ->numeric()
                                    ->required()
                                    ->prefix('৳'),
                                TextInput::make('stock')
                                    ->numeric()
                                    ->default(0),
                            ])->columnSpanFull()->columns(3)
                    ])
            ]);
    }
}
