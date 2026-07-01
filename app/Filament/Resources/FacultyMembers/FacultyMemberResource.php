<?php

namespace App\Filament\Resources\FacultyMembers;

use App\Filament\Resources\FacultyMembers\Pages\CreateFacultyMember;
use App\Filament\Resources\FacultyMembers\Pages\EditFacultyMember;
use App\Filament\Resources\FacultyMembers\Pages\ListFacultyMembers;
use App\Filament\Resources\FacultyMembers\Schemas\FacultyMemberForm;
use App\Filament\Resources\FacultyMembers\Tables\FacultyMembersTable;
use App\Models\FacultyMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FacultyMemberResource extends Resource
{
    protected static ?string $model = FacultyMember::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Academics';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return FacultyMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FacultyMembersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFacultyMembers::route('/'),
            'create' => CreateFacultyMember::route('/create'),
            'edit' => EditFacultyMember::route('/{record}/edit'),
        ];
    }
}
