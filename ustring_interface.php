<?php

interface UstringInterface
{
    public function reverse();
    public function substr();
    public function has();
    public function count();
    public function split();
    public function at();
    public function replace();

    public function index();
    public function lfind();
    public function rfind();

    public function lower();
    public function upper();

    public function isalpha();
    public function isdigit();
    public function isalnum();
    public function isnumeric();
}