<?php
use yii\helpers\Html;

/**
 * /** Представление для actionList
 * @var $this yii\web\View */
$this->title = 'Сводная таблица';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="site-index">
        <div class="container">
            <h3>Введите начальную и конечную даты</h3>
            <form class="form-signin"  action="/site/list" method="post">
                <div>
                    <input type="date" name = "date1" class="form-control" autofocus>
                    <input type="date" name = "date2" class="form-control">
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Отправить</button>
            </form>

        </div> <!-- /container -->
    </div> <!-- /site-index -->

</div>

<?php
if (isset($result))
{
    $itogo = array_pop($result)['sum'];

echo "<h2 class='sub-header'>Сводный биллинг</h2>
          <div class='table-responsive'>
            <table class='table table-striped'>
              <thead>
                <tr>
                  <th>Сеть</th>
                  <th>Агенство</th>
                  <th>Сумма</th>
                </tr>
              </thead>";

      echo "<tbody>";

    foreach ($result as $item) {
            echo "<tr >

                  <td >$item[agency_network_name]</td >
                  <td >$item[agency_name]</td >
                  <td >$item[sum]</td >
                  </tr >";
        }

    echo "<tr >
                  <td colspan='2'>Итого:</td >
                  <td >$itogo</td >
                  </tr >";

    echo "</table></table></div>";

}
?>
