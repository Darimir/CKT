<?php
/*Вывод данных в зависимости от конфигурации*/

require __DIR__ . '/controller/choice.php';

$list = items_list();

require __DIR__ . '/view/list.php';