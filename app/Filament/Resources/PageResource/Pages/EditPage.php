<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['blocks_json'] = self::normalizeBlocks($data['blocks_json'] ?? []);

        return $data;
    }

    private static function normalizeBlocks(mixed $blocks): array
    {
        if (!is_array($blocks)) {
            return [];
        }

        foreach ($blocks as $i => $block) {
            if (!is_array($block)) {
                continue;
            }

            if (isset($block['video']) && is_array($block['video'])) {
                $block['video'] = reset($block['video']) ?: null;
            }

            for ($n = 1; $n <= 6; $n++) {
                $key = 'image_' . $n;
                if (isset($block[$key]) && is_array($block[$key])) {
                    $block[$key] = reset($block[$key]) ?: null;
                }
            }

            $blocks[$i] = $block;
        }

        return $blocks;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
