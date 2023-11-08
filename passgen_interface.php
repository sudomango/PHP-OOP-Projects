<?php

declare(strict_types = 1);

interface PassGenInterface
{
    public function generate(int $length, int $count = 1, bool $use_numbers = True, bool $use_symbols = True): void;
}