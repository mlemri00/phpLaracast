<?php
$llibres =[
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

    function filter($items, $fn){
        $itemsFiltrats = [];

        foreach($items as $item){
            if($fn($item)){
                $itemsFiltrats[] = $item;
            }
        }

        return $itemsFiltrats;
    };

    $llibresFiltrats = filter($llibres,function($llibre){
        return $llibre["autor"] === "Albert Camus";
    });

require "index.view.php";