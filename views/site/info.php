<?php

/**
 * Представление для вывода сообщений
 * @var $this yii\web\View
 */

?>
<div class="site-error">

    <div class="alert alert-danger">
       <?php
       if (isset($msg)) echo $msg;
?>
    </div>

</div>
