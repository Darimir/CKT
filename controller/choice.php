<?php

require __DIR__ . '/../model/DB.php';

function items_list()
{
    require __DIR__ . '/../config.inc.php';

    if ($choice)
    {
        $list = get_list_db();
    }
    else
    {
        $list =  get_list_res($res);
    }
    return $list;
}