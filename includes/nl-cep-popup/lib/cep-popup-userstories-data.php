<?php

$user_stories_data = array(
    "start" => array(
        "name" => "start",
        "type" => "page",
        "include" => "/includes/nl-cep-popup/views/view-cep-popup-index.php",
        "options" => array(
            "option1" => array(
                "nextAction" => "cepCheck",
                "description" => "checar meu cep"
            ),
            "option2" => array(
                "nextAction" => "pickupInStore",
                "description" => "retire na loja"
            )
        ),
    ),
    "cepCheck" => array(
        "name" => "cepCheck",
        "type" => "page",
        "include" => '/includes/nl-cep-popup/views/view-cep-popup-check-cep.php',
        "options" => array(
            "option1" => array(
                "nextAction" => "cepCheckResult",
                "description" => "avançar"
            ),
            "option2" => array(
                "nextAction" => "cepBusca",
                "description" => "nao sabe seu cep"
            )
        ),
    ),
    "cepCheckResult" => array(
        "name" => "cepCheckResult",
        "type" => "request",
        "include" => "",
        "options" => array(
            "option1" => array(
                "nextAction" => "cepCheckSuccess",
                "description" => ""
            ),
            "option2" => array(
                "nextAction" => "cepCheckFailed",
                "description" => ""
            )
        ),
    ),
    "cepCheckSuccess" => array(
        "name" => "cepCheckSuccess",
        "type" => "page",
        "include" => "",
        "options" => array(
            "option1" => array(
                "nextAction" => "pickupInStore",
                "description" => "seguir para o site"
            )
        ),
    ),
    "cepCheckFailed" => array(
        "name" => "cepCheckFailed",
        "type" => "page",
        "include" => "",
        "options" => array(
            "option1" => array(
                "nextAction" => "pickupInStore",
                "description" => "seguir para o site"
            )
        ),
    ),
    "pickupInStore" => array(
        "name" => "pickupInStore",
        "type" => "request",
        "include" => "",
        "options" => array(
            "option1" =>  array(
                "nextAction" => "endingPoint",
                "description" => ""
            )
        ),
    ),
    "end" => array(
        "name" => "end",
        "type" => "page",
        "include" => "",
        "options" => [],
    )
);
