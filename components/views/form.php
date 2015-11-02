<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 08.10.2015
 * Time: 9:22
 */
?>
<div class="site-index">
    <div class="container">
        <h3>Рассчет минимальной разницы D массивов</h3>
        <button type="button" class="btn btn-info" id="add">Добавить поле ввода</button>
        <form class="form-signin"  action="/site/calc" method="post">
                <div id="digitalInput">
                <input type="number" name = "input1" class="form-control" placeholder="Число от -1000 до 1000" autofocus>
                <input type="number" name = "input2" class="form-control" placeholder="Число от -1000 до 1000">
                <input type="number" name = "input3" class="form-control" placeholder="Число от -1000 до 1000">
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Вычислить</button>
        </form>

    </div> <!-- /container -->
</div> <!-- /site-index -->
