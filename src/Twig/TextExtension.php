<?php

namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TextExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('humanize', [$this, 'camelCaseToWordsFilter']),
        ];
    }

    /**
     * Convert camelCase to Separate Words
     *
     * @param string $text text in camel case
     * @return string the same text with separate ucfirst words
     */
    public function camelCaseToWordsFilter(string $text): string
    {
        $words = preg_split('/(?=[A-Z])/', $text);
        $ucwords = array_map('ucfirst', $words);
        $out = implode(' ', $ucwords);

        return $out;
    }
}
