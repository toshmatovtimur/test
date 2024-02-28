<?php

/** @var app\models\Users $model */
?>

<?php foreach ($model as $item): ?>

<?=  $item->id  . '<br/>' . 'Почта: ' . $item->email . '<br/>' . 'Роль: ' . $item->nameRole . '<br/>'; ?>

<?php endforeach; ?>

<?php
//echo '<br/>';
//echo '<br/>';
//var_dump($query);








