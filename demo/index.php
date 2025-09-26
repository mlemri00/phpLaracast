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
    ];

    $llibresFiltrats = function($items, $key, $value){
        $itemsFiltrats = [];

        foreach($items as $item){
            if($item[$key] === $value){
                $itemsFiltrats[] = $item;
            }
        }

        return $itemsFiltrats;
    };

    $llibresFiltrats = $llibresFiltrats($llibres,"autor","Dostoevsky");

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