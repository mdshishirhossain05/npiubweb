<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')->required()->unique(ignoreRecord: true),
                        TextInput::make('short_name'),
                        TextInput::make('established_year')->numeric(),
                        SpatieMediaLibraryFileUpload::make('image')
                            ->collection('image')
                            ->image()
                            ->imageEditor()
                            ->columnSpanFull(),
                        Textarea::make('summary')->rows(2)->columnSpanFull(),
                        RichEditor::make('overview')->columnSpanFull(),
                        TextInput::make('priority')->numeric()->default(1),
                        Toggle::make('is_active')->default(true),
                    ]),

                Section::make('SEO')
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title'),
                        Textarea::make('meta_description')->rows(2),
                    ]),
            ]);
    }
}
