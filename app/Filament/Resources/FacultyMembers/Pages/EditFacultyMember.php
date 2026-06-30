<?php

namespace App\Filament\Resources\FacultyMembers\Pages;

use App\Filament\Resources\FacultyMembers\FacultyMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFacultyMember extends EditRecord
{
    protected static string $resource = FacultyMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
