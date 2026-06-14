<?php
namespace App\Filament\Resources\AffiliateClickResource\Pages;use App\Filament\Resources\AffiliateClickResource;use Filament\Actions;use Filament\Resources\Pages\EditRecord;class EditAffiliateClick extends EditRecord{protected static string $resource=AffiliateClickResource::class;protected function getHeaderActions():array{return [Actions\DeleteAction::make()];}}
