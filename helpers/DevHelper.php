<?php

namespace app\helpers;

/**
 * Class DevHelper - хелпер, в котором собраны функции для облегчения разработки / тестирования приложения
 */
abstract class DevHelper
{
    /**
     * Выводит значение пеерменной $var внутри тега <pre></pre>
     *
     * @param $var
     * @param boolean $must_die
     * @param boolean $var_dump - вар_дамп или принт_р для вывода
     */
    public static function preArray($var, $must_die = false, $var_dump = false)
    {
        echo "<pre>";
        $var_dump ? var_dump($var) : print_r($var);
        echo "</pre>";

        if ($must_die) {
            die;
        }
    }
}