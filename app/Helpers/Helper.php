<?php

namespace App\Helpers;

/**
 * Request Class helper
 */
class Helper
{
    public static function viToEn($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(đ)/", "d", $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(Đ)/", "D", $str);
        $str = str_replace(" ", "-", str_replace("&*#39;", "", $str));

        return strtolower($str);
    }

    public static function makeSlug($text, string $divider = '-')
    {
        $text = self::viToEn($text);
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function handleKeySeo($string)
    {
        $string = self::removeTrashKeySeo($string);
        $string = self::removeSpecialCharacter($string);

        return $string;
    }

    public static function removeSpecialCharacter($string)
    {
        $string = str_replace("“", "", $string);
        $string = str_replace("”", "", $string);
        $string = str_replace("'", "", $string);
        $string = str_replace('"', "", $string);
        $string = str_replace("/", " ", $string);
        $string = str_replace("\\", " ", $string);
        $string = str_replace("~", " ", $string);
        $string = str_replace("|", " ", $string);
        $string = str_replace("@", " ", $string);
        $string = str_replace("$", " ", $string);
        $string = str_replace("&", " ", $string);
        $string = str_replace("^", " ", $string);
        $string = str_replace("*", " ", $string);
        $string = str_replace("-", " ", $string);
        $string = str_replace("+", " ", $string);
        $string = str_replace(":", " ", $string);
        $string = str_replace("=", " ", $string);
        $string = str_replace("(", "", $string);
        $string = str_replace(")", "", $string);
        $string = str_replace("`", " ", $string);
        $string = str_replace("#", " ", $string);
        $string = str_replace("%", " ", $string);
        $string = str_replace("^", " ", $string);
        $string = str_replace("_", " ", $string);
        $string = str_replace("[", " ", $string);
        $string = str_replace("]", " ", $string);
        $string = str_replace("{", " ", $string);
        $string = str_replace("}", " ", $string);
        $string = str_replace(";", " ", $string);
        $string = str_replace("'", " ", $string);
        $string = str_replace(",", " ", $string);
        $string = str_replace(".", " ", $string);
        $string = str_replace("<", " ", $string);
        $string = str_replace(">", " ", $string);
        $string = str_replace("?", " ", $string);
        $string = str_replace("!", " ", $string);
        $string = str_replace("-", " ", $string);
        $string = str_replace("–", " ", $string);
        $string = str_replace("       ", " ", $string);
        $string = str_replace("      ", " ", $string);
        $string = str_replace("     ", " ", $string);
        $string = str_replace("    ", " ", $string);
        $string = str_replace("   ", " ", $string);
        $string = str_replace("  ", " ", $string);

        return $string;
    }

    public static function removeTrashKeySeo($string)
    {
        $trashes = [
            '[Tip Android]',
            '[Tip iOS]',
            'Tip Android',
            'Tip iOS',
            '[Mẹo]',
            '[Video]',
            '[Có thể bạn chưa biết]',
            'nhanh – gọn – lẹ',
            'Nhanh – Gọn – Lẹ',
            'NHANH – GỌN – LẸ',
            'cực tiện lợi không phải ai cũng biết',
            'Cực tiện lợi không phải ai cũng biết',
            'không nên bỏ qua',
            'Không nên bỏ qua',
            'không phải ai cũng biết',
            'Không phải ai cũng biết',
            'toàn diện nhất',
            'Toàn diện nhất',
            'có thể bạn chưa biết',
            'Có thể bạn chưa biết',
            'cực kì đơn giản',
            'Cực kì đơn giản',
            'đảm bảo thành công',
            'Đảm bảo thành công',
            'không nên bỏ lỡ',
            'Không nên bỏ lỡ',
            'nhanh gọn đơn giản',
            'Nhanh gọn đơn giản',
            'chính xác',
            'Chính xác',
            'chính xác nhất',
            'Chính xác nhất',
            'có gì đặc biệt',
            'Có gì đặc biệt',
            'một nốt nhạc',
            'Một nốt nhạc',
            'cực tiện lợi',
            'Cực tiện lợi',
            'cực đơn giản',
            'Cực đơn giản',
            'đơn giản nhất',
            'Đơn giản nhất',
            'siêu đơn giản',
            'Siêu đơn giản',
            'tiện lợi hơn',
            'Tiện lợi hơn',
            'hiệu quả nhất',
            'Hiệu quả nhất',
            'cực hữu ích',
            'Cực hữu ích',
            'bạn nên biết',
            'Bạn nên biết',
            'độc lạ',
            'Độc lạ',
            'mới ra mắt',
            'Mới ra mắt',
            'đơn giản',
            'Đơn giản',
            'dễ dàng',
            'Dễ dàng',
            'hiệu quả',
            'Hiệu quả',
            'nhanh chóng',
            'Nhanh chóng',
            'Hô biến',
            'hô biến',
            'cực dễ',
            'Cực dễ',
            'nên biết',
            'Nên biết',
            'nhanh gọn',
            'Nhanh gọn',
            'hợp lí',
            'Hợp lí',
            'Hướng dẫn bạn',
        ];
        foreach ($trashes as $trash) {
            $string = str_replace($trash, '', $string);
        }

        $before = [
            'cách' => 'cách',
            'tính năng' => 'các tính năng',
            'ứng dụng' => 'những ứng dụng',
            'phần mềm' => 'những Các phần mềm',
            'thủ thuật' => 'top thủ thuật',
            'cách xử lý' => 'các cách xử lý',
            'lưu ý' => 'những lưu ý',
            'bước' => 'các bước',
            'lý do' => 'các lý do',
            'mẹo' => 'mẹo',
            'bí kíp' => 'bí kíp',
            'bí quyết' => 'bí quyết',
            'nguyên nhân' => 'nguyên nhân',
            'thói quen' => 'thói quen',
            'điều' => 'những điều',
            'tuyệt chiêu' => 'những tuyệt chiêu',
            'Loại' => 'Loại',
            'loại' => 'loại',
        ];
        foreach ($before as $key_bf => $value_bf) {
            for ($number = 1; $number < 50; $number++) {
                $temp_bf = $number . ' ' . $key_bf;
                $string = str_replace($temp_bf, $value_bf, $string);
            }
        }

        $after = [
            'Tổng hợp' => 'tổng hợp các',
            'Top' => 'top các',
            'Mách bạn' => ''
        ];
        foreach ($after as $key_at => $value_at) {
            for ($number = 1; $number < 50; $number++) {
                $temp_at = $key_at . ' ' . $number;
                $string = str_replace($temp_at, $value_at, $string);
            }
        }

        return $string;
    }
}
