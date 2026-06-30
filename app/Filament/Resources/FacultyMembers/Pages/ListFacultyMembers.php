<?php

namespace App\Filament\Resources\FacultyMembers\Pages;

use App\Filament\Resources\FacultyMembers\FacultyMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFacultyMembers extends ListRecords
{
    protected static string $resource = FacultyMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
