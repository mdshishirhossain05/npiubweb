<?php

namespace App\Filament\Resources\AdmissionInquiries\Pages;

use App\Filament\Resources\AdmissionInquiries\AdmissionInquiryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdmissionInquiries extends ListRecords
{
    protected static string $resource = AdmissionInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
