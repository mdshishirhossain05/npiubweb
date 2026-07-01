<?php

namespace App\Filament\Resources\People\Schemas;

use App\Models\Person;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PersonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profile')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Used in the page URL.'),
                        Select::make('type')
                            ->required()
                            ->options([
                                Person::TYPE_FACULTY => 'Faculty',
                                Person::TYPE_OFFICER => 'Officer',
                                Person::TYPE_LEADERSHIP => 'Leadership / Office',
                            ])
                            ->default(Person::TYPE_FACULTY),
                        Select::make('department_id')
                            ->label('Department')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('position')
                            ->required(),
                        TextInput::make('office_type')
                            ->label('Office (for leadership)')
                            ->helperText('e.g. Administration, Board'),
                        SpatieMediaLibraryFileUpload::make('photo')
                            ->collection('photo')
                            ->image()
                            ->imageEditor()
                            ->columnSpanFull(),
                        Textarea::make('biography')
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),

                Section::make('Academic')
                    ->columns(2)
                    ->schema([
                        TagsInput::make('degrees')
                            ->placeholder('Add a degree')
                            ->helperText('e.g. PhD, MSc'),
                        TagsInput::make('research_interests')
                            ->placeholder('Add an interest'),
                    ]),

                Section::make('Contact & meta')
                    ->columns(2)
                    ->schema([
                        TextInput::make('email')->email(),
                        TextInput::make('contact'),
                        TextInput::make('facebook')->url(),
                        TextInput::make('linkedin')->url(),
                        TextInput::make('whatsapp'),
                        TextInput::make('priority')->numeric()->default(1),
                        Toggle::make('is_active')->default(true),
                        TextInput::make('meta_title')->columnSpanFull(),
                        Textarea::make('meta_description')->rows(2)->columnSpanFull(),
                    ]),
            ]);
    }
}
