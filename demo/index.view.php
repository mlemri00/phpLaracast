
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        body{
            display:grid;
            place-items:center;
            height: 100vh;
            margin:0;
            font-family: sans-serif;
        }
    </style>
</head>
<body>

?>

<ul>
    <?php foreach($llibresFiltrats as $llibre): ?>
        <li>
            <a href="<?=$llibre["urlCompra"]?>">
                <?=$llibre["nom"];?>(<?= $llibre["any"]?>)
            </a>
        </li>

    <?php endforeach; ?>
</ul>
<p>

</p>

</body>
</html>