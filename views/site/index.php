<?php
/* @var $this yii\web\View
 * @var $result string
 */
use app\components\FormWidget;
$this->registerJsFile('@web/js/index.js',['position' => $this::POS_READY],'index');
$this->title = 'Работа с Формами';
?>
<?= FormWidget::widget();
if (isset($result))
{
    echo '<div class="panel panel-primary">
          <div class="panel-body">
          Минимальная разница D равна
          </div>
          <div class="panel-footer">'
          ."$result
          </div></div>";
}
?>
