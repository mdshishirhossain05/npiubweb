<?php

namespace App\Filament\Resources\AdmissionInquiries\Pages;

use App\Filament\Resources\AdmissionInquiries\AdmissionInquiryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAdmissionInquiry extends EditRecord
{
    protected static string $resource = AdmissionInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
