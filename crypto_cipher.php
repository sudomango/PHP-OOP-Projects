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