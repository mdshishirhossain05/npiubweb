<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Article')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->collection('cover')
                            ->image()
                            ->imageEditor()
                            ->columnSpanFull(),
                        Textarea::make('excerpt')
                            ->rows(2)
                            ->maxLength(300)
                            ->columnSpanFull(),
                        RichEditor::make('content')
                            ->required()
                            ->columnSpanFull(),
                    ]),

                Section::make('Author & publishing')
                    ->columns(2)
                    ->schema([
                        TextInput::make('author_name'),
                        TextInput::make('author_info'),
                        SpatieMediaLibraryFileUpload::make('author')
                            ->collection('author')
                            ->image()
                            ->avatar()
                            ->columnSpanFull(),
                        TextInput::make('category')->required()->default('general'),
                        DatePicker::make('published_at')->required()->default(now()),
                        Select::make('status')
                            ->options(['draft' => 'Draft', 'published' => 'Published'])
                            ->default('published')
                            ->required(),
                    ]),

                Section::make('SEO')
                    ->columns(1)
                    ->collapsed()
                    ->schema([
                        TextInput::make('meta_title'),
                        Textarea::make('meta_description')->rows(2),
                    ]),
            ]);
    }
}
