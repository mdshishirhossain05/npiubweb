<?php

namespace App\Enums;

/**
 * Publication state shared by every editorial content model.
 *
 * Kept deliberately small (draft / published). Anything that needs a richer
 * lifecycle later — scheduling, archiving — should add cases here rather than
 * inventing per-model status columns.
 */
enum ContentStatus: string
{
    case Draft = 'draft';
    case Published = 'published';

    /**
     * Human-friendly label for admin UIs and Filament selects.
     */
    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Published => 'Published',
        };
    }

    /**
     * @return array<string, string> value => label, for use in form options
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}
