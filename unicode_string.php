<?php

declare(strict_types=1);
require_once "ustring_interface.php";

class Ustring
{
    private $content;

    function __construct(string $some_text)
    {
        mb_internal_encoding("UTF-8");
        mb_regex_encoding("UTF-8");
        $this->content = $some_text;
    }

    function reverse()
    {
        $chars = mb_str_split($this->content, 1, "UTF-8");
        return implode("", array_reverse($chars));
    }

    function substr(int $start_index, int $length): string
    {
        if ($length === 0) return "";
        $str_length = mb_strlen($this->content, "UTF-8");

        $result_string = "";
        if ($length > 0) {
            for ($i = $start_index; $i < $start_index + $length; $i++) {
                if (in_array($i, range(-$str_length, $str_length + 1))) {
                    $result_string .= mb_substr($this->content, $i, 1, "UTF-8");
                }
            }
        } else {
            for ($i = $start_index; $i > $start_index - abs($length); $i--) {
                if (in_array($i, range(-$str_length, $str_length + 1))) {
                    $result_string .= mb_substr($this->content, $i, 1, "UTF-8");
                }
            }
        }
        return $result_string;
    }

    function slice(int $start_index, int $length): string
    {
        return $this->substr($start_index, $length);
    }

    function at(int $index): string
    {
        $length = mb_strlen($this->content, "UTF-8");
        if ($index >= $length) $index %= $length;
        if ($index < 0) {
            while ($index < 0) $index += $length;
        }
        return mb_substr($this->content, $index, 1, "UTF-8");
    }

    function has(string $substring): bool
    {
        $result = mb_strpos($this->content, $substring, 0, "UTF-8");
        return is_integer($result) ? True : False;
    }

    function count(string $substring): int
    {
        return mb_substr_count($this->content, $substring);
    }

    function length(): int
    {
        return mb_strlen($this->content, "UTF-8");
    }

    function split(): array
    {
        return mb_str_split($this->content, 1, "UTF-8");
    }

    function replace(string $find, string $replace, bool $ignore_case = False): string
    {
        if ($ignore_case) return mb_eregi_replace($find, $replace, $this->content);
        else return mb_ereg_replace($find, $replace, $this->content);
    }

    function index(string $substring, int $position = 0): int
    {
        return mb_strpos($this->content, $substring, $position, "UTF-8");
    }

    function rindex(string $substring, int $position = -1): int
    {
        return mb_strrpos($this->content, $substring, $position, "UTF-8");
    }

    function lfind(string $substring, int $position = 0): int
    {
        return $this->index($substring, $position);
    }

    function rfind(string $substring, int $position = -1): int
    {
        return $this->rindex($substring, $position);
    }

    function lower()
    {
        return mb_strtolower($this->content, "UTF-8");
    }

    function upper()
    {
        return mb_strtoupper($this->content, "UTF-8");
    }

    # Проверяет, состоит ли строка только из буквенных символов.
    function isalpha(): bool
    {
        return preg_match("/^\w+$/misu", $this->content);
    }

    # Проверяет, состоит ли строка только из буквенных символов и цифр.
    function isalnum(): bool
    {
        return preg_match("/^[\w\d]+$/misu", $this->content);
    }

    # Проверяет, состоит ли строка только из цифр.
    function isdigit(): bool
    {
        return preg_match("/^\d+$/", $this->content);
    }

    # Проверяет, является ли строка записью произвольного целого числа.
    function isinteger(): bool
    {
        return preg_match("/^[+-]?\d+$/", $this->content);
    }

    # Проверяет, является ли строка записью произвольного числа (целого или вещественного).
    function isnumber(): bool
    {
        return preg_match("/^[+-]?\d+[\.]?\d*$/", $this->content);
    }
}