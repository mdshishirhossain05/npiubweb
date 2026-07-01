<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')->required()->unique(ignoreRecord: true),
                        DateTimePicker::make('starts_at')->required(),
                        DateTimePicker::make('ends_at'),
                        TextInput::make('venue'),
                        Select::make('status')
                            ->options(['draft' => 'Draft', 'published' => 'Published'])
                            ->default('published')
                            ->required(),
                        Toggle::make('is_featured')->label('Feature on home page'),
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->collection('cover')
                            ->image()
                            ->imageEditor()
                            ->columnSpanFull(),
                        RichEditor::make('description')->columnSpanFull(),
                    ]),

                Section::make('SEO')
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title'),
                        TextInput::make('meta_description'),
                    ]),
            ]);
    }
}
