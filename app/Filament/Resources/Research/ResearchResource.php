<?php

namespace App\Filament\Resources\Research;

use App\Filament\Concerns\HasPanelAccess;
use App\Filament\Resources\Research\Pages\CreateResearch;
use App\Filament\Resources\Research\Pages\EditResearch;
use App\Filament\Resources\Research\Pages\ListResearch;
use App\Filament\Resources\Research\Schemas\ResearchForm;
use App\Filament\Resources\Research\Tables\ResearchTable;
use App\Models\Research;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ResearchResource extends Resource
{
    use HasPanelAccess;

    protected static ?string $model = Research::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Academics';

    protected static ?int $navigationSort = 4;

    protected static ?string $accessPermission = 'manage_content';

    public static function form(Schema $schema): Schema
    {
        return ResearchForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ResearchTable::configure($table);
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
            'index' => ListResearch::route('/'),
            'create' => CreateResearch::route('/create'),
            'edit' => EditResearch::route('/{record}/edit'),
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
