<?php

namespace App\Filament\Resources\Alumni\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AlumnusForm
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
                TextInput::make('department_label'),
                TextInput::make('batch'),
                TextInput::make('graduation_year')
                    ->numeric(),
                TextInput::make('current_position'),
                Textarea::make('bio')
                    ->columnSpanFull(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('facebook'),
                TextInput::make('linkedin'),
                TextInput::make('whatsapp'),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('legacy_id')
                    ->numeric(),
            ]);
    }
}
