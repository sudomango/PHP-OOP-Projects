<?php

require_once "unicode_string.php";
require_once "crypto_cipher.php";
require_once "password_generator.php";

# Пример использования класса PasswordGenerator для генерации случайных паролей.

echo ("================================\n");

echo "Набор случайных паролей:" . PHP_EOL;

$passwd = new PasswordGenerator();
$passwd->generate(8, 5, True, False);

echo ("================================\n");

echo PHP_EOL;

# Пример использования класса Ustring для удобной и корректной работы с кодировкой UTF-8.

echo ("================================\n");

$utext = new Ustring("Приветствую вас, дорогие друзья!");
echo "Исходный текст = {$utext->get_content()}" . PHP_EOL;
echo "Длина текста = {$utext->length()}" . PHP_EOL;
echo "Перевёрнутая строка = {$utext->reverse()->get_content()}" . PHP_EOL;

# Выводим "Дорогие, друзья!" = сначала берём первую букву "д" по индексу, обращаем её в верхний регистр. После чего выводим остаток текста.
$large_d = $utext->at($utext->index("д"))->upper()->get_content(); # = Д
$rest_of_text = $utext->slice($utext->index("орог"), $utext->length())->get_content(); # = орогие друзья!
echo "Манипуляции с символами = $large_d$rest_of_text" . PHP_EOL;

$is_alpha = $utext->isalpha() ? "True" : "False";
echo "В строке только буквенные символы? = $is_alpha" . PHP_EOL;

# Очищаем содержимое $utext от всех небуквенных символов.
$result_string = new Ustring("");
foreach (range(0, $utext->length() - 1) as $index) {
    $current_char = $utext->at($index);
    if ($current_char->isalpha()) {
        $result_string->set_content($result_string->get_content() . $current_char->get_content());
    }
}
echo "Больше в строке нет небуквенных символов (даже пробелов) = {$result_string->get_content()}" . PHP_EOL;

echo ("================================\n");

echo PHP_EOL;

# Пример использования классов самописной библиотеки CryptoCipher.

echo ("================================\n");

$cipher = new CryptoCipher();
$original_text = "Привет, PHP! Привет, 1С!";

echo "Использование классического шифра Цезаря:" . PHP_EOL;
$caesar_text = $cipher->Caesar->encode($original_text, $step = 30);
echo $caesar_text . PHP_EOL;
echo "Декодируем обратно: ", $cipher->Caesar->decode($caesar_text, $step = 30) . PHP_EOL;

echo PHP_EOL;

echo "Использование модифицированного шифра Цезаря:" . PHP_EOL;
$caesar_mod_text = $cipher->CaesarMod->encode($original_text, $step = 30);
echo $caesar_mod_text . PHP_EOL;
echo "Декодируем обратно: ", $cipher->CaesarMod->decode($caesar_mod_text, $step = 30) . PHP_EOL;

echo ("================================\n");