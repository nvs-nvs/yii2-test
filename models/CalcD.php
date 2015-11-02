<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 08.10.2015
 * Time: 9:31
 */
namespace app\models;

class CalcD
{
    public static function calculateD(array $a)
    {
        /*Вычисляем стартовую сумму, чтобы потом не дергать count()*/
        $start_sum=array_sum($a);
        $D=INF;
        $count=count($a);
        for ($i=1;$i<$count;$i++)
        {
            /*Помещаем первый элемент в новый массивв, тем самым деля старый на два*/
            $b[] = array_shift($a);
            $b_sum = array_sum($b);
            /*Сумму оставшегося массива вычисляем вычитаением, а не count()*/
            $tempD = abs($b_sum - ($start_sum - $b_sum));
            if ($tempD < $D) {
            $D = $tempD;
            }
        };
        return $D;
    }
}