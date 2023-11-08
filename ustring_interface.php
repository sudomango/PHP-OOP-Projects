<?php

declare(strict_types = 1);

interface UstringInterface
{
    public function get_content(): string;
    public function set_content(string $new_string): bool;

    public function reverse(): Ustring;
    public function substr(int $start_index, int $length): Ustring;
    public function slice(int $start_index, int $length): Ustring;
    public function at(int $index): Ustring;
    public function has(string $substring): bool;
    public function count(string $substring): int;
    public function length(): int;
    public function split(): array;
    public function replace(string $find, string $replace, bool $ignore_case = False): Ustring;

    public function index(string $substring, int $position = 0): int;
    public function rindex(string $substring, int $position = -1): int;
    public function lfind(string $substring, int $position = 0): int;
    public function rfind(string $substring, int $position = -1): int;

    public function lower(): Ustring;
    public function upper(): Ustring;

    public function isalpha(): bool;
    public function isalnum(): bool;
    public function isdigit(): bool;
    public function isinteger(): bool;
    public function isnumber(): bool;
}