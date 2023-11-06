<?php

require_once "ustring_interface.php";
declare(use_strict = 1);

class Ustring
{
    private $content;

    function __construct(string $some_text)
    {
        $this->content = $some_text;
    }

    function at(int $index): string
    {
        $length = iconv_strlen($this->content, "UTF-8");
        if ($index >= $length) $index %= $length;
        if ($index < 0) {
            while ($index < 0) $index += $length;
        }
        return iconv_substr($this->content, $index, 1, "UTF-8");
    }

    function has(string $substring): bool
    {
        $result = iconv_strpos($this->content, $substring, 0, "UTF-8");
        return is_integer($result) ? True : False;
    }

    function count(string $substring): int
    {
        $count = 0;
        $index = 0;
        $length = iconv_strlen($this->content, "UTF-8");
        $length_substr = iconv_strlen($substring, "UTF-8");
        
        while ($index < $length) {
            $result = iconv_strpos($this->content, $substring, $index, "UTF-8");
            if (is_integer($result)) {
                $count += 1;
                $index = $result + $length_substr + 1;
            } else {
                $index = $length; # Можно также выйти из цикла при помощи инструкции break.
            }
        }

        return $count;
    }

    function length(): int
    {
        return iconv_strlen($this->content, "UTF-8");
    }

    function index(string $substring, int $position): int
    {
        return iconv_strpos($this->content, $substring, $position, "UTF-8");
    }

    function rindex(string $substring, int $position): int
    {
        return iconv_strrpos($this->content, $substring, $position, "UTF-8");
    }

    function lfind(string $substring, int $position): int
    {
        return $this->index($substring, $position);
    }

    function rfind(string $substring, int $position): int
    {
        return $this->rindex($substring, $position);
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