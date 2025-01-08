<?php

namespace App\Utils;

class SeoUtils
{
    public static function generateDescription($product)
    {
        $plainText = strip_tags($product->description);

        $plainText = preg_replace('/\s+/', ' ', $plainText);
        $plainText = trim($plainText);

        $description = mb_substr($plainText, 0, 150);

        if (strlen($plainText) > 150) {
            $description .= '...';
        }

        return $description;
    }

    public static function generateKeywords($product)
    {
        $keywords = [];

        $keywords[] = $product->name;
        $keywords[] = $product->brand?->name ?? '';
        $keywords[] = $product->category?->name ?? '';

        $additionalKeywords = self::extractKeywords($product->description);
        $keywords = array_merge($keywords, $additionalKeywords);

        $keywords = array_unique($keywords);

        return implode(', ', $keywords);
    }

    private static function extractKeywords($text)
    {
        $text = strtolower(strip_tags($text));
        $text = preg_replace('/[^a-z0-9\s\-]/', '', $text);

        $words = explode(' ', $text);
        $frequency = array_count_values($words);

        $stopWords = ['và', 'của', 'là', 'một', 'trong', 'với', 'các', 'để'];
        foreach ($frequency as $word => $count) {
            if (in_array($word, $stopWords) || strlen($word) < 3) {
                unset($frequency[$word]);
            }
        }

        arsort($frequency);
        return array_slice(array_keys($frequency), 0, 5);
    }
}
