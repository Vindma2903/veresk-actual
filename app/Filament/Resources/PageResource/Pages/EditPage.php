<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['blocks_json'] = self::normalizeBlocks($data['blocks_json'] ?? []);
        $this->deleteReplacedBlockVideos($data['blocks_json']);

        return $data;
    }

    private function deleteReplacedBlockVideos(array $newBlocks): void
    {
        $oldBlocks = $this->record?->blocks_json;
        if (!is_array($oldBlocks)) {
            return;
        }

        foreach ($newBlocks as $index => $newBlock) {
            if (!is_array($newBlock)) {
                continue;
            }

            $oldBlock = $oldBlocks[$index] ?? null;
            if (!is_array($oldBlock)) {
                continue;
            }

            $oldVideo = $oldBlock['video'] ?? null;
            $newVideo = $newBlock['video'] ?? null;

            if (
                is_string($oldVideo) &&
                $oldVideo !== '' &&
                is_string($newVideo) &&
                $newVideo !== '' &&
                $oldVideo !== $newVideo
            ) {
                Storage::disk('public')->delete($oldVideo);
            }
        }
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

    protected function getFormActions(): array
    {
        if (($this->record?->slug ?? null) === 'landshaftnoe-proektirovanie') {
            return [];
        }

        return parent::getFormActions();
    }
}
