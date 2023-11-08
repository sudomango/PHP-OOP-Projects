<?php

declare(strict_types = 1);
require_once "unicode_string.php";
require_once "cipher_interface.php";

# Классический Шифр Цезаря для английского и русского алфавита.

class CaesarStand
{
    private $alphabet;

    function __construct()
    {
        # Алфавит будет содержать коды для символов "A".."Z", "a".."z", "А".."я", "0".."9" в кодировке UTF-8.
        $this->alphabet = array_merge(range(65, 90), range(97, 122), range(1040, 1103), range(48, 57));
    }

    public function encode(string $input_string, int $step, bool $decode = False): string
    {
        if ($step === 0 or $input_string === "") return $input_string;

        $result_string = "";
        $user_string = new Ustring($input_string);
        $alpha_length = count($this->alphabet);

        for ($index = 0; $index < $user_string->length(); $index++) {
            $char_ord = mb_ord($user_string->at($index));
            if (in_array($char_ord, $this->alphabet)) {
                $key_in_array = array_search($char_ord, $this->alphabet);
                $new_key = !$decode ? $key_in_array + $step : $key_in_array - $step;
                if ($new_key >= $alpha_length) $new_key %= $alpha_length;
                else while ($new_key < 0) $new_key += $alpha_length;
                $result_string .= mb_chr($this->alphabet[$new_key]);
            } else {
                $result_string .= $user_string->at($index);
            }
        }
        return $result_string;
    }

    public function decode(string $input_string, int $step): string
    {
        return $this->encode($input_string, $step, $decode = True);
    }
}

# Немного нестандартный шифр Цезаря, который использует не весь алфавит целиком, а только буквы, представленные в самой строке.
# С точки зрения "секретности" такой шифр может оказаться менее полезным, но с точки зрения алгоритмической реализации, он немного интереснее.

class Caesar
{
    public function encode(string $input_string, int $step, bool $decode = False): string
    {
        if ($step === 0 or $input_string === "") return $input_string;

        # Разбиваем строку на массив символов, оставляем все символы в единственном экземпляре, сортируем этот массив.
        $chars = mb_str_split($input_string, 1, "UTF-8");
        $chars = array_unique($chars); sort($chars);
        $chars_length = count($chars);
        $user_string = new Ustring($input_string);

        # Составляем новую строку из символов получившегося массива со сдвигом, указанным в $step.
        $result_string = "";
        for ($index = 0; $index < $user_string->length(); $index++) {
            # Находим очередной символ пользовательской строки в нашем массиве "символов".
            $key_in_array = array_search($user_string->at($index), $chars);
            # В зависимости от флага кодирования / декодирования сдвигаем индекс в нужную сторону.
            $new_key = !$decode ? $key_in_array + $step : $key_in_array - $step;
            # Если получившийся индекс вылез за границы массива, делаем корректировку.
            if ($new_key >= $chars_length) $new_key %= $chars_length;
            else while ($new_key < 0) $new_key += $chars_length;
            $result_string .= $chars[$new_key];
        }
        return $result_string;
    }

    public function decode(string $input_string, int $step): string
    {
        return $this->encode($input_string, $step, $decode = True);
    }
}

# Реализация шифра Вернана - один из простейших шифров, тем не менее, при выполнении некоторых условий, обладает абсолютной криптографической стойкостью.

class Vernam
{
    public function encode(string $input_string, int $secret_key = 313): array
    {
        $chars = mb_str_split($input_string);
        $result_array = array();
        foreach ($chars as $char) {
            $ord = mb_ord($char);
            array_push($result_array, $ord ^ $secret_key);
        }
        return $result_array;
    }

    public function decode(array $code_array, int $secret_key = 313): string
    {
        $result_string = "";
        foreach ($code_array as $code) {
            $char = mb_chr($code ^ $secret_key);
            $result_string .= $char;
        }
        return $result_string;
    }
}

class CryptoCipher
{
    public $Caesar;
    public $CaesarStand;
    public $Vernam;

    function __construct()
    {
        $this->Caesar = new Caesar();
        $this->CaesarStand = new CaesarStand();
        $this->Vernam = new Vernam();
    }
}