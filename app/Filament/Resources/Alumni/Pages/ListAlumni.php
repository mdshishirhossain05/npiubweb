<?php

namespace App\Filament\Resources\Alumni\Pages;

use App\Filament\Resources\Alumni\AlumnusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlumni extends ListRecords
{
    protected static string $resource = AlumnusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
