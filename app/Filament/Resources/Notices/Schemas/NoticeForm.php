<?php

namespace App\Filament\Resources\Notices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NoticeForm
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
                        TextInput::make('category')->required()->default('general'),
                        DatePicker::make('notice_date')->required()->default(now()),
                        TextInput::make('published_by'),
                        Toggle::make('is_important')->label('Mark as important'),
                        RichEditor::make('description')->required()->columnSpanFull(),
                        SpatieMediaLibraryFileUpload::make('attachment')
                            ->collection('attachment')
                            ->downloadable()
                            ->helperText('Optional PDF or document attachment.')
                            ->columnSpanFull(),
                        Select::make('status')
                            ->options(['draft' => 'Draft', 'published' => 'Published'])
                            ->default('published')
                            ->required(),
                    ]),
            ]);
    }
}
