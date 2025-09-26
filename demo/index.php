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
                "autor"=>"Dostoevsky",
                "any"=>1848,
                "urlCompra"=>"https://lacasadellibro.com"
        ],
        [
                "nom"=>"El extranjero",
                "autor"=>"Albert Camus",
                "any"=>1948,
                "urlCompra"=>"https://lacasadellibro.com"
        ],

            [
                    "nom"=>"La peste",
                    "autor"=>"Albert Camus",
                    "any"=>1938,
                    "urlCompra"=>"https://lacasadellibro.com"
            ]
    ]
    ?>

    <ul>
     <?php foreach($llibres as $llibre): ?>
     <?php if($llibre["autor"] === "Albert Camus" ):?>
     <li>
         <a href="<?=$llibre["urlCompra"]?>">
            <?=$llibre["nom"];?>(<?= $llibre["any"]?>)
         </a>
     </li>
         <?php endif; ?>
        <?php endforeach; ?>
    </ul>

</body>
</html>