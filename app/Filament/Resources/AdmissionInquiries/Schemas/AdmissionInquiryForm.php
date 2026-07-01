<?php

namespace App\Filament\Resources\AdmissionInquiries\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AdmissionInquiryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                Select::make('program_id')
                    ->relationship('program', 'name'),
                TextInput::make('program_label'),
                Textarea::make('message')
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->default('new'),
                DateTimePicker::make('handled_at'),
            ]);
    }
}
