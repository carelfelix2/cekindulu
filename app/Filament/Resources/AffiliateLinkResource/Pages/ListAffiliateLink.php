<?php
namespace App\Filament\Resources\AffiliateLinkResource\Pages;use App\Filament\Resources\AffiliateLinkResource;use Filament\Actions;use Filament\Resources\Pages\ListRecords;class ListAffiliateLink extends ListRecords{protected static string $resource=AffiliateLinkResource::class;protected function getHeaderActions():array{return [Actions\CreateAction::make()];}}
