<?php

namespace App\Filament\Resources\Research\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ResearchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('excerpt')
                    ->columnSpanFull(),
                TextInput::make('author_name'),
                TextInput::make('author_info'),
                TextInput::make('category')
                    ->required(),
                DatePicker::make('published_at')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('published'),
                TextInput::make('meta_title'),
                Textarea::make('meta_description')
                    ->columnSpanFull(),
                TextInput::make('legacy_id')
                    ->numeric(),
            ]);
    }
}
