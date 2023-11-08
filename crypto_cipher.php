<?php

require_once "unicode_string.php";

# Классический Шифр Цезаря для английского и русского алфавита.

class CaesarStand
{
    private $alphabet;

    function __construtct()
    {
        $this->alphabet = array_merge(range('A', 'Z'), range('a', 'z'), range('А', 'Я'), range('а', 'я'), range('0', '9'));
    }

    public function encode(string $input_string, int $step, bool $decode = False): string
    {
        if ($step === 0 or $input_string === "") return $input_string;

        $result_string = "";
        $user_string = new Ustring($input_string);
        $alpha_length = mb_strlen($this->alphabet);

        for ($index = 0; $index < $user_string->length(); $index++) {
            $key_in_array = array_search($user_string->at($index), $this->alphabet);
            $new_key = !$decode ? $key_in_array + $step : $key_in_array - $step;
            if ($new_key >= $alpha_length) $new_key %= $alpha_length;
            else while ($new_key < 0) $new_key += $alpha_length;
            $result_string .= $this->alphabet[$new_key];
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