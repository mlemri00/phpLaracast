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
    <?php $llibres =[
        [
                "nom"=>"Noches blancas",
                "autor"=>"Dostoevsky"
        ],
        [
                "nom"=>"El extranjero",
                "autor"=>"Albert Camus"
        ]
    ]
    ?>

    <ul>
     <?php foreach($llibres as $llibre): ?>
     <li><?=$llibre["nom"]?></li>
        <?php endforeach; ?>
    </ul>

</body>
</html>