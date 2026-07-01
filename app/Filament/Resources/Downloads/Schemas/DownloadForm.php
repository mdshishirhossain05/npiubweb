<?php

namespace App\Filament\Resources\Downloads\Schemas;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DownloadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')->required()->unique(ignoreRecord: true),
                TextInput::make('category'),
                SpatieMediaLibraryFileUpload::make('file')
                    ->collection('file')
                    ->downloadable()
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description')->rows(2)->columnSpanFull(),
                TextInput::make('priority')->numeric()->default(1),
                Toggle::make('is_active')->default(true),
            ]);
    }
}
