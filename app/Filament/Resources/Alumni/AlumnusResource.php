<?php

namespace App\Filament\Resources\Alumni;

use App\Filament\Concerns\HasPanelAccess;
use App\Filament\Resources\Alumni\Pages\CreateAlumnus;
use App\Filament\Resources\Alumni\Pages\EditAlumnus;
use App\Filament\Resources\Alumni\Pages\ListAlumni;
use App\Filament\Resources\Alumni\Schemas\AlumnusForm;
use App\Filament\Resources\Alumni\Tables\AlumniTable;
use App\Models\Alumnus;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AlumnusResource extends Resource
{
    use HasPanelAccess;

    protected static ?string $model = Alumnus::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 7;

    protected static ?string $accessPermission = 'manage_content';

    public static function form(Schema $schema): Schema
    {
        return AlumnusForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AlumniTable::configure($table);
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
            'index' => ListAlumni::route('/'),
            'create' => CreateAlumnus::route('/create'),
            'edit' => EditAlumnus::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
