<?php
//Провереряем можно ли подключиться к базе и существует ли база указанная в конфиге
function connect_db ()
{
    require __DIR__ . '/config.php';
    $conn = mysql_connect($database_server, $database_user, $database_password);
    if ($conn)
    {
        mysql_query($database_connection_charset);

            if(mysql_select_db($dbase))
            {
                return $conn;
            }
            else
            {
                $new_db = 'CREATE DATABASE ' . $dbase;
                $add_db = mysql_query($new_db);
                if($add_db)
                {
                    return $conn;
                }
                else
                {
                    die(mysql_error());
                }
            }

    }
    else
    {
        die(mysql_error());
    }
}

//Проверяем есть ли таблица в базе, если нет то создаем и возвращаем ее название
function table_exist()
{
    connect_db();

    $sql = 'CREATE TABLE IF NOT EXISTS `Configuration` (
	  id INT AUTO_INCREMENT,
	  nm varchar(50),
	  vl varchar(50),
	  PRIMARY KEY(id)
	)';

    if (mysql_query($sql))
    {
       return 'Configuration';
    }
    else
    {
        die(mysql_error());
    }
}

function get_list_db()
{
    $table_name = table_exist();

    if($table_name)
    {
        $sql = 'SELECT * FROM ' . $table_name;

        $rs = mysql_query($sql);

        while($row = mysql_fetch_assoc($rs)) {
            $data[] = $row;
        }
        return $data;
    }
}

function get_list_res($url)
{
    $request = '<GetPrefs MsgType="GetPrefs" MsgNum="' . microtime() . '"></GetPrefs> ';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    //Передаваемые параметры!
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request );

    //Делаем запрос!
    $res = curl_exec($curl);

   if(!$res)
    {
        $error = curl_error($curl).'('.curl_errno($curl).')';
        echo $error;
    }
    //если не ошибка, то возвращаем результат
    else
    {
        $lists = new SimpleXMLElement($res);
        $list = $lists->Items;
        $l=$list->Item;
        return $l;
    }

    curl_close($curl);

}

