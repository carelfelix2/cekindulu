<?php
namespace App\Filament\Resources\AffiliateClickResource\Pages;use App\Filament\Resources\AffiliateClickResource;use Filament\Actions;use Filament\Resources\Pages\ListRecords;class ListAffiliateClick extends ListRecords{protected static string $resource=AffiliateClickResource::class;protected function getHeaderActions():array{return [Actions\CreateAction::make()];}}
