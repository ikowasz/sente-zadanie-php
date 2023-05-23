<?php

namespace App\Enum;

enum SortDirection: string
{
    case ASC = 'asc';
    case DESC = 'desc';

    public const DEFAULT = SortDirection::ASC;

    /**
     * Get direction from sortOrder string representation
     *
     * @param string $direction String representation
     * @return SortDirection Direction, default if given invalid
     */
    public static function fromString(string $direction): SortDirection
    {
        return self::tryFrom(strtolower($direction)) ?? self::DEFAULT;
    }

    /**
     * Get oposite direction
     *
     * @return SortDirection Reverted direction
     */
    public function toggle(): SortDirection
    {
        switch ($this) {
            case SortDirection::ASC:
                return SortDirection::DESC;
            case SortDirection::DESC:
                return SortDirection::ASC;
        }

        return SortDirection::DEFAULT;
    }
}
