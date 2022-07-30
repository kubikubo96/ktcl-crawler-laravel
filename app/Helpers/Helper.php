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
        $string = str_replace("    ", " ", $string);
        $string = str_replace("   ", " ", $string);
        $string = str_replace("  ", " ", $string);

        $index = 60;
        if (strlen($string) < $index) {
            $index = strlen($string) - 1;
        }
        return self::subStringWhileSpace($string, $index);
    }

    public static function subStringWhileSpace($string, $index)
    {
        $temp_string = substr($string, 0, $index);
        if ($string[$index] != ' ') {
            return self::subStringWhileSpace($string, $index - 1);
        } else {
            return $temp_string;
        }
    }
}
