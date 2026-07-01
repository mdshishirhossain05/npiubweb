<?php

namespace App\Filament\Resources\AdmissionInquiries;

use App\Filament\Concerns\HasPanelAccess;
use App\Filament\Resources\AdmissionInquiries\Pages\CreateAdmissionInquiry;
use App\Filament\Resources\AdmissionInquiries\Pages\EditAdmissionInquiry;
use App\Filament\Resources\AdmissionInquiries\Pages\ListAdmissionInquiries;
use App\Filament\Resources\AdmissionInquiries\Schemas\AdmissionInquiryForm;
use App\Filament\Resources\AdmissionInquiries\Tables\AdmissionInquiriesTable;
use App\Models\AdmissionInquiry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdmissionInquiryResource extends Resource
{
    use HasPanelAccess;

    protected static ?string $model = AdmissionInquiry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|\UnitEnum|null $navigationGroup = 'Submissions';

    protected static ?int $navigationSort = 2;

    protected static ?string $accessPermission = 'view_submissions';

    public static function form(Schema $schema): Schema
    {
        return AdmissionInquiryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdmissionInquiriesTable::configure($table);
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
            'index' => ListAdmissionInquiries::route('/'),
            'create' => CreateAdmissionInquiry::route('/create'),
            'edit' => EditAdmissionInquiry::route('/{record}/edit'),
        ];
    }
}
