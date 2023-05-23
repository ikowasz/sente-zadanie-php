<?php

namespace App\Twig;

use App\Enum\SortDirection;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class OrdersExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('sortOrderIcon', [$this, 'sortOrderIconFunction']),
            new TwigFunction('toggleSortOrder', [$this, 'toggleSortOrderFunction']),
        ];
    }

    /**
     * Get icon indicating given sort direction
     *
     * @param string $sortOrder Direction for the icon
     * @return string Icon string representation to be rendered
     */
    public function sortOrderIconFunction(string $sortOrder): string
    {
        $direction = SortDirection::fromString($sortOrder);

        switch ($direction) {
            case SortDirection::ASC:
                return '&#9652;';
            case SortDirection::DESC:
                return '&#9662;';
            default:
                return '';
        }
    }

    /**
     * Toggles direction of table sorting
     *
     * @param string $currentOrder Current direction value
     * @return string Next direction value
     */
    public function toggleSortOrderFunction(string $sortOrder): string
    {
        // $direction = SortDirection::fromString($sortOrder);

        // return SortDirection::toggle($direction)->value;
        return SortDirection::fromString($sortOrder)->toggle()->value;
    }
}
