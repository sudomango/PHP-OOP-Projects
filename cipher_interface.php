<?php

declare(strict_types = 1);

interface CaesarStandInterface
{
    public function encode(string $input_string, int $step, bool $decode = False): string;
    public function decode(string $input_string, int $step): string;
}

interface CaesarInterface
{
    public function encode(string $input_string, int $step, bool $decode = False): string;
    public function decode(string $input_string, int $step): string;
}

interface VernamInterface
{
    public function encode(string $input_string, int $secret_key = 313): array;
    public function decode(array $code_array, int $secret_key = 313): string;
}