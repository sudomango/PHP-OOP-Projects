<?php

declare(strict_types=1);

interface UstringInterface
{
    public function reverse(): string;
    public function substr(int $start_index, int $length): string;
    public function slice(int $start_index, int $length): string;
    public function at(int $index): string;
    public function has(string $substring): bool;
    public function count(string $substring): int;
    public function length(): int;
    public function split(): array;
    public function replace(string $find, string $replace, bool $ignore_case = False): string;

    public function index(string $substring, int $position = 0): int;
    public function rindex(string $substring, int $position = -1): int;
    public function lfind(string $substring, int $position = 0): int;
    public function rfind(string $substring, int $position = -1): int;

    public function lower(): string;
    public function upper(): string;

    public function isalpha(): bool;
    public function isalnum(): bool;
    public function isdigit(): bool;
    public function isinteger(): bool;
    public function isnumber(): bool;
}