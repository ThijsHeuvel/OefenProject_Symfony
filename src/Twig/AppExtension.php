<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('shorten', [$this, 'shorten']),
        ];
    }


    public function shorten($string, $length, $shortenWith = '...')
    {
        if (mb_strlen($string) > $length) {
            $string = mb_substr($string, 0, $length - mb_strlen($shortenWith)) . $shortenWith;
        }
        return $string;
    }

}