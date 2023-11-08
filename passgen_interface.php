<?php

declare(strict_types = 1);

interface PassGenInterface
{
    public function generate(int $length, int $count = 1, bool $use_numbers = true, bool $use_symbols = true): void;
}