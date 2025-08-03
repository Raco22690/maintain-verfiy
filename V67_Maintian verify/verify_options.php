<?php
header('Content-Type: application/json');

$options = [
    'clean_pad_type' => [
        "A Type",
        "B Type",
        "C Type"
    ],
    'verify_sort' => [
        "Sort1",
        "Sort2",
        "Sort3",
        "Sort1,2",
        "Sort1,2,3"
    ],
    'verify_method' => [
        "Method A",
        "Method B",
        "Method C"
    ],
    'rule_verify_pass' => [
        "Rule A",
        "Rule B"
    ],
    'rule_contact_window' => [
        "Contact Rule X",
        "Contact Rule Y"
    ],
    'rule_dib_check' => [
        "DIB Rule 1",
        "DIB Rule 2"
    ]
];

echo json_encode($options);
?> 