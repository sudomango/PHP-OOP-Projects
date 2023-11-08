<?php

declare(strict_types=1);
require_once "ustring_interface.php";

class Ustring implements UstringInterface
{
    private $content;

    function __construct(string $some_text)
    {
        mb_internal_encoding("UTF-8");
        mb_regex_encoding("UTF-8");
        $this->content = $some_text;
    }

    # Перевернуть содержимое строки задом наперёд.
    public function reverse(): string
    {
        $chars = mb_str_split($this->content, 1);
        return implode("", array_reverse($chars));
    }

    # Получить подстроку из исходной строки по начальному индексу и длине. В этом методе есть немного "магии".
    # Он реализован так, что мы можем задавать отрицательные значения как для индекса, так и для длины подстроки.
    # Если длина отрицательная, то символы будут собираться в обратную сторону: от конца исходной строки к её началу.
    # Например: $ustring->substr(-1, -3) = мы получим подстроку, содержащую символы из исходной строки с индексами -1, -2, -3.
    public function substr(int $start_index, int $length): string
    {
        if ($length === 0) return "";
        $str_length = mb_strlen($this->content);

        $result_string = "";
        if ($length > 0) {
            for ($i = $start_index; $i < $start_index + $length; $i++) {
                if (in_array($i, range(-$str_length, $str_length + 1))) {
                    $result_string .= mb_substr($this->content, $i, 1);
                }
            }
        } else {
            for ($i = $start_index; $i > $start_index - abs($length); $i--) {
                if (in_array($i, range(-$str_length, $str_length + 1))) {
                    $result_string .= mb_substr($this->content, $i, 1);
                }
            }
        }
        return $result_string;
    }

    # Синоним метода substr для почитателей языка Python.
    public function slice(int $start_index, int $length): string
    {
        return $this->substr($start_index, $length);
    }

    # Получить символ строки по его индексу. Особенность данного метода в том, что он умеет гулять "по кругу".
    # То есть после достижения конца строки, он перейдёт на её нулевой элемент, а по достижению самого начала = на последний.
    public function at(int $index): string
    {
        $length = mb_strlen($this->content);
        if ($index >= $length) $index %= $length;
        if ($index < 0) {
            while ($index < 0) $index += $length;
        }
        return mb_substr($this->content, $index, 1);
    }

    # Проверить, есть ли данная подстрока или символ в исходной строке.
    public function has(string $substring): bool
    {
        $result = mb_strpos($this->content, $substring, 0);
        return is_integer($result) ? True : False;
    }

    # Подсчитать количество вхождений подстроки или символа в исходную строку.
    public function count(string $substring): int
    {
        return mb_substr_count($this->content, $substring);
    }

    public function length(): int
    {
        return mb_strlen($this->content);
    }

    # Разбить строку на массив символов. Каждый элемент массива = 1 символ исходной строки.
    public function split(): array
    {
        return mb_str_split($this->content, 1);
    }

    # Заменить одну подстроку на другую. Поиск подстроки можно вести как с учётом регистра символов, так и без учёта регистра.
    public function replace(string $find, string $replace, bool $ignore_case = False): string
    {
        if ($ignore_case) return mb_eregi_replace($find, $replace, $this->content);
        else return mb_ereg_replace($find, $replace, $this->content);
    }

    # Поиск первого вхождения указанного символа или подстроки в исходную строку. Можно указать с какого индекса начинать поиск.
    public function index(string $substring, int $position = 0): int
    {
        return mb_strpos($this->content, $substring, $position);
    }

    # Поиск первого вхождения указанного символа или подстроки в исходную строку. Данный метод ведёт поиск с конца строки (справа налево).
    public function rindex(string $substring, int $position = -1): int
    {
        return mb_strrpos($this->content, $substring, $position);
    }

    # Псевдоним для метода index, может показаться удобнее для запоминания.
    public function lfind(string $substring, int $position = 0): int
    {
        return $this->index($substring, $position);
    }

    # Псевдоним для метода rindex, может показаться удобнее для запоминания.
    public function rfind(string $substring, int $position = -1): int
    {
        return $this->rindex($substring, $position);
    }

    # Перевод всех символов строки в нижний регистр.
    public function lower(): string
    {
        return mb_strtolower($this->content);
    }

    # Перевод всех символов строки в верхний регистр (грубо говоря, Caps Lock).
    public function upper(): string
    {
        return mb_strtoupper($this->content);
    }

    # Проверяет, состоит ли строка только из буквенных символов.
    public function isalpha(): bool
    {
        return preg_match("/^\w+$/misu", $this->content);
    }

    # Проверяет, состоит ли строка только из буквенных символов и цифр.
    public function isalnum(): bool
    {
        return preg_match("/^[\w\d]+$/misu", $this->content);
    }

    # Проверяет, состоит ли строка только из цифр (0 .. 9).
    public function isdigit(): bool
    {
        return preg_match("/^\d+$/", $this->content);
    }

    # Проверяет, является ли строка записью произвольного целого числа. Допустимые форматы записи: "+123", "1080", "-312".
    public function isinteger(): bool
    {
        return preg_match("/^[+-]?\d+$/", $this->content);
    }

    # Проверяет, является ли строка записью произвольного числа (целого или вещественного). В теле строки допускается одна разделительная точка.
    public function isnumber(): bool
    {
        return preg_match("/^[+-]?\d+[\.]?\d*$/", $this->content);
    }
}