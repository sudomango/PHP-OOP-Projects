<?php

declare(strict_types=1);

class PasswordGenerator
{
    private $letters_a;
    private $letters_b;
    private $numbers;
    private $symbols;

    public function __construct()
    {
        $this->letters_a = range('A', 'Z');
        $this->letters_b = range('a', 'z');
        $this->numbers = range(0, 9);
        $this->symbols = ['.', ',', '!', '#', '$', '%', '&', '*', '(', ')', '+', '-', '/', ';', '~', '<', '>'];
    }

    public function generate(int $length, int $count = 1, bool $use_numbers = true, bool $use_symbols = true): void
    {
        if ($length < 1) $length = 1;
        if ($count < 1) $count = 1;

        $passwords_array = array();
        $chars = array_merge($this->letters_a, $this->letters_b);
        if ($use_numbers) {
            $chars = array_merge($chars, $this->numbers, $this->numbers);
        }
        if ($use_symbols) {
            $chars = array_merge($chars, $this->symbols, $this->symbols);
        }
        shuffle($chars);
        foreach (range(0, $count - 1) as $x) {
            $password = "";
            foreach (range(0, $length - 1) as $index) {
                $rand_key = array_rand($chars);
                $password .= $chars[$rand_key];
            }
            $passwords_array[] = $password;
        }

        $this->print_passwords($passwords_array);
    }

    private function print_passwords(array $passwords): void
    {
        foreach ($passwords as $password) {
            echo $password . PHP_EOL;
        }
    }
}