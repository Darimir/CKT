<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<ul>
<?php foreach($list as $items):?>
<li><?php echo $items['nm'] . ' - ' . $items['vl']; ?></li>
<?php endforeach ?>
</ul>
</body>
</html>


