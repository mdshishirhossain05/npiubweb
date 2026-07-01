<?php

namespace App\Filament\Resources\Sliders\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SliderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                SpatieMediaLibraryFileUpload::make('image')
                    ->collection('image')
                    ->image()
                    ->imageEditor()
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('title'),
                TextInput::make('subtitle'),
                TextInput::make('cta_label')->label('Button label'),
                TextInput::make('cta_url')->label('Button URL')->url(),
                TextInput::make('sort_order')->numeric()->default(0),
                Toggle::make('is_active')->default(true),
            ]);
    }
}
