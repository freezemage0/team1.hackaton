<?php
namespace Core\Utility;

class Debug
{
    protected static $timers = array();

    /**
     * Выводит отладочную информацию о переменной.
     * Оборачивает вывод в тег <pre> для удобства использования в вебе.
     *
     * @param $expr
     * @param null $label
     * @return void
     */
    public static function dump($expr, $label = null)
    {
        ob_start();
        if (isset($label)) {
            echo $label;
        }
        ?><pre><?var_dump($expr);?></pre><?
        echo ob_get_clean();
    }

    /**
     * Начинает замер времени.
     *
     * @param $label
     * @return void
     */
    public static function startTime($label)
    {
        static::$timers[$label]['start'] = microtime(true);
    }

    /**
     * Заканчивает замер времени.
     *
     * @param $label
     * @return void
     */
    public static function endTime($label)
    {
        static::$timers[$label]['end'] = microtime(true);
    }

    /**
     * Возвращает массив таймеров.
     *
     * @return array
     */
    public static function getTimes()
    {
        foreach (static::$timers as $label => $times) {
            static::$timers[$label]['difference'] = $times['end'] - $times['start'];
        }

        return static::$timers;
    }
}