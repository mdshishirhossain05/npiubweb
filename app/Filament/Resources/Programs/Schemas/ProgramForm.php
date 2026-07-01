<?php

namespace App\Filament\Resources\Programs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Select::make('department_id')
                    ->relationship('department', 'name'),
                TextInput::make('level')
                    ->required()
                    ->default('undergraduate'),
                TextInput::make('duration'),
                TextInput::make('total_credits'),
                Textarea::make('overview')
                    ->columnSpanFull(),
                Textarea::make('curriculum')
                    ->columnSpanFull(),
                Textarea::make('fees')
                    ->columnSpanFull(),
                TextInput::make('priority')
                    ->required()
                    ->numeric()
                    ->default(1),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('meta_title'),
                Textarea::make('meta_description')
                    ->columnSpanFull(),
            ]);
    }
}
