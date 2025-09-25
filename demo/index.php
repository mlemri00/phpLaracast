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
    <?php
        $nom = "Memorias del subsuelo";
        $llegit = true;

        if ($llegit) {
            $missatge = "Tú m'has llegit";
        }else{
            $missatge = "Tú no m'has llegit";
        }
    ?>
    <h1><?php echo $missatge; ?>
        <?=$missatge?>
    </h1>

</body>
</html>