<?php

namespace App\Utils;

use Illuminate\Support\Str;

class SeoUtils
{
    public static function generateSeoData($product)
    {
        $rawTitle = $product->name
            . (!empty($product->brand->name) ? ' - ' . $product->brand->name : '')
            . (!empty($product->category->name) ? ' | ' . $product->category->name : '');

        // Giới hạn ~60 ký tự (có thể tuỳ biến)
        $metaTitle = Str::limit($rawTitle, 60, '...');

        // ---------
        // 2. Tạo Meta Description
        // ---------
        //   - Loại bỏ thẻ HTML
        //   - Cố gắng lấy câu đầu tiên hoặc 160 ký tự đầu tiên
        //   - Có thể thêm 1-2 từ khóa quan trọng

        $plainDescription = strip_tags($product->description ?? '');
        $plainDescription = trim($plainDescription);

        // Lấy câu đầu tiên (nếu cần). Hoặc cắt 160 ký tự.
        // Dùng match() hoặc Regular Expression tách câu, 
        // nhưng đơn giản nhất là cắt 160 ký tự.

        $metaDescription = Str::limit($plainDescription, 160, '...');

        // ---------
        // 3. Tạo Meta Keywords
        // ---------
        //   - Tổng hợp từ: name + brand + category + (1 vài keyword bổ sung)
        //   - Loại bỏ trùng, xóa dấu tiếng Việt, filter stop words, ...
        //   - Google không dùng meta keywords để xếp hạng, 
        //     nhưng các search engine khác có thể có.

        // Lấy dữ liệu thô cho từ khoá
        $keywordSource = $product->name . ' '
            . ($product->brand->name ?? '') . ' '
            . ($product->category->name ?? '');

        // Tách thành mảng
        $keywordsArray = explode(' ', $keywordSource);

        // 3.1. Chuyển về chữ thường
        $keywordsArray = array_map('mb_strtolower', $keywordsArray);

        // 3.2. Xoá dấu tiếng Việt (nếu bạn muốn)
        // Định nghĩa sẵn 1 hàm removeVietnameseAccents() bên dưới
        $keywordsArray = array_map(function ($k) {
            return self::removeVietnameseAccents($k);
        }, $keywordsArray);

        // 3.3. Loại bỏ ký tự đặc biệt, chỉ giữ [a-z0-9-...] (tuỳ biến)
        $keywordsArray = array_map(function ($keyword) {
            // \p{L} là pattern cho unicode letter 
            // \p{N} là pattern cho unicode number
            return preg_replace('/[^\p{L}\p{N}\-]+/u', '', $keyword);
        }, $keywordsArray);

        // 3.4. Loại bỏ các từ vô nghĩa (stop words) nếu muốn
        // Ví dụ 1 list dăm ba từ tiếng Việt hay gặp
        $stopWords = [
            'và',
            'hoặc',
            'cho',
            'các',
            'những',
            'một',
            'có',
            'là',
            'bị',
            'của',
            'the',
            'of',
            'in',
            'to',
            'on'
            // ... tuỳ bạn
        ];
        $keywordsArray = array_filter($keywordsArray, function ($item) use ($stopWords) {
            return !in_array($item, $stopWords) && $item !== '';
        });

        // 3.5. Xoá trùng lặp
        $keywordsArray = array_unique($keywordsArray);

        // 3.6. Chuyển mảng thành chuỗi
        $metaKeywords = implode(',', $keywordsArray);

        // ---------
        // 4. Kết quả trả về
        // ---------
        return [
            'title'       => $metaTitle,
            'description' => $metaDescription,
            'keywords'    => $metaKeywords,
        ];
    }

    /**
     * Hàm removeVietnameseAccents
     * Loại bỏ dấu tiếng Việt
     */
    public static function removeVietnameseAccents($str)
    {
        $accents = [
            'à',
            'á',
            'ạ',
            'ả',
            'ã',
            'â',
            'ầ',
            'ấ',
            'ậ',
            'ẩ',
            'ẫ',
            'ă',
            'ằ',
            'ắ',
            'ặ',
            'ẳ',
            'ẵ',
            'è',
            'é',
            'ẹ',
            'ẻ',
            'ẽ',
            'ê',
            'ề',
            'ế',
            'ệ',
            'ể',
            'ễ',
            'ì',
            'í',
            'ị',
            'ỉ',
            'ĩ',
            'ò',
            'ó',
            'ọ',
            'ỏ',
            'õ',
            'ô',
            'ồ',
            'ố',
            'ộ',
            'ổ',
            'ỗ',
            'ơ',
            'ờ',
            'ớ',
            'ợ',
            'ở',
            'ỡ',
            'ù',
            'ú',
            'ụ',
            'ủ',
            'ũ',
            'ư',
            'ừ',
            'ứ',
            'ự',
            'ử',
            'ữ',
            'ỳ',
            'ý',
            'ỵ',
            'ỷ',
            'ỹ',
            'đ',
            'À',
            'Á',
            'Ạ',
            'Ả',
            'Ã',
            'Â',
            'Ầ',
            'Ấ',
            'Ậ',
            'Ẩ',
            'Ẫ',
            'Ă',
            'Ằ',
            'Ắ',
            'Ặ',
            'Ẳ',
            'Ẵ',
            'È',
            'É',
            'Ẹ',
            'Ẻ',
            'Ẽ',
            'Ê',
            'Ề',
            'Ế',
            'Ệ',
            'Ể',
            'Ễ',
            'Ì',
            'Í',
            'Ị',
            'Ỉ',
            'Ĩ',
            'Ò',
            'Ó',
            'Ọ',
            'Ỏ',
            'Õ',
            'Ô',
            'Ồ',
            'Ố',
            'Ộ',
            'Ổ',
            'Ỗ',
            'Ơ',
            'Ờ',
            'Ớ',
            'Ợ',
            'Ở',
            'Ỡ',
            'Ù',
            'Ú',
            'Ụ',
            'Ủ',
            'Ũ',
            'Ư',
            'Ừ',
            'Ứ',
            'Ự',
            'Ử',
            'Ữ',
            'Ỳ',
            'Ý',
            'Ỵ',
            'Ỷ',
            'Ỹ',
            'Đ'
        ];
        $noAccents = [
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'a',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'e',
            'i',
            'i',
            'i',
            'i',
            'i',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'o',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'u',
            'y',
            'y',
            'y',
            'y',
            'y',
            'd',
            'A',
            'A',
            'A',
            'A',
            'A',
            'A',
            'A',
            'A',
            'A',
            'A',
            'A',
            'A',
            'A',
            'A',
            'A',
            'A',
            'A',
            'E',
            'E',
            'E',
            'E',
            'E',
            'E',
            'E',
            'E',
            'E',
            'E',
            'E',
            'I',
            'I',
            'I',
            'I',
            'I',
            'O',
            'O',
            'O',
            'O',
            'O',
            'O',
            'O',
            'O',
            'O',
            'O',
            'O',
            'O',
            'O',
            'O',
            'O',
            'O',
            'O',
            'U',
            'U',
            'U',
            'U',
            'U',
            'U',
            'U',
            'U',
            'U',
            'U',
            'U',
            'Y',
            'Y',
            'Y',
            'Y',
            'Y',
            'D'
        ];

        return str_replace($accents, $noAccents, $str);
    }
}
