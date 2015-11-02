<?php

namespace app\models;
/**
 * Class CalcD
 * @package app\models
 * Класс отвечает за вычисление минимальной разницы D.
 * @const $D итоговая разность изначально равна +бесконечности.
 * @var array $a хранит пришедший массив.
 * @var array $b хранит новый массив.
 * @var integer $b_sum хранит сумму элементов $b.
 * @var integer $tempD хранит временную разность по ее модулю.
 * @var array $start_sum хранит начальную сумму элементов пришедшего массива,
 * чтобы потом не дергать каждый раз count()*.
 * @return integer $D итоговая разность
 */
class CalcD
{

    public static function calculateD(array $a)
    {
        $start_sum = array_sum($a);
        $D = INF;
        $count = count($a);
        for ($i = 1; $i < $count; $i++) {
            /* Помещаем первый элемент в новый массивв, тем самым деля старый на два */
            $b[] = array_shift($a);
            $b_sum = array_sum($b);
            /* Сумму оставшегося массива вычисляем вычитаением, а не count() */
            $tempD = abs($b_sum - ($start_sum - $b_sum));
            if ($tempD < $D) {
                $D = $tempD;
            }
        };
        return $D;
    }
}