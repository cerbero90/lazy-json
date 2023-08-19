<?php

return [
    'complex_array' => [
        '*.batters' => [
            'batters' => [
                [
                    'batter' => [
                        [
                            "id" => "1001",
                            "type" => "Regular",
                        ],
                        [
                            "id" => "1002",
                            "type" => "Chocolate",
                        ],
                        [
                            "id" => "1003",
                            "type" => "Blueberry",
                        ],
                        [
                            "id" => "1004",
                            "type" => "Devil's Food",
                        ],
                    ],
                ],
                [
                    'batter' => [
                        [
                            "id" => "1001",
                            "type" => "Regular",
                        ],
                    ],
                ],
                [
                    'batter' => [
                        [
                            "id" => "1001",
                            "type" => "Regular",
                        ],
                        [
                            "id" => "1002",
                            "type" => "Chocolate",
                        ],
                    ],
                ],
            ],
        ],
        '*.batters.batter' => [
            'batter' => [
                [
                    [
                        "id" => "1001",
                        "type" => "Regular",
                    ],
                    [
                        "id" => "1002",
                        "type" => "Chocolate",
                    ],
                    [
                        "id" => "1003",
                        "type" => "Blueberry",
                    ],
                    [
                        "id" => "1004",
                        "type" => "Devil's Food",
                    ],
                ],
                [
                    [
                        "id" => "1001",
                        "type" => "Regular",
                    ],
                ],
                [
                    [
                        "id" => "1001",
                        "type" => "Regular",
                    ],
                    [
                        "id" => "1002",
                        "type" => "Chocolate",
                    ],
                ],
            ],
        ],
    ],
    'complex_object' => [
        'batters' => [
            'batters' => [
                [
                    'batter' => [
                        [
                            "id" => "1001",
                            "type" => "Regular",
                        ],
                        [
                            "id" => "1002",
                            "type" => "Chocolate",
                        ],
                        [
                            "id" => "1003",
                            "type" => "Blueberry",
                        ],
                        [
                            "id" => "1004",
                            "type" => "Devil's Food",
                        ],
                    ],
                ],
            ],
        ],
        'batters.batter' => [
            'batter' => [
                [
                    [
                        "id" => "1001",
                        "type" => "Regular",
                    ],
                    [
                        "id" => "1002",
                        "type" => "Chocolate",
                    ],
                    [
                        "id" => "1003",
                        "type" => "Blueberry",
                    ],
                    [
                        "id" => "1004",
                        "type" => "Devil's Food",
                    ],
                ],
            ],
        ],
    ],
];
