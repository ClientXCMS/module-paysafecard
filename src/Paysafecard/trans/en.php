<?php
return [
    'paysafecard' => [
        'success' => "Transfer being verified to receive credits.",
        'cancel' => "Fund transfer canceled.",
        'accept' => "Transfer accepted successfully.",
        'refuse' => "Transfer refused successfully.",

        'change' => "Card value switched.",
        "form" => [
            "pin" => "PIN Code",
            "value" => "Card value",
            "giveback" => "Credits giveback",
            "submit" => "Submit",
        ],
        "states" => [
            "Pending" => "Pending",
            "Accepted" => "Accepted",
            "Refused" => "Refused",
            "Cancelled" => "Canceled",
        ],
        "admin" => [
            "title" => "Paysafecard Transfers",
            "subtitle" => "Manager Paysafecard transfers to Credit.",
            "warning" => "Once the card has been confirmed, the giveback will be directly added to the account. <br/> The first button cancels the code, the second accepts and the third rejects the code.",
            "check" => "Check a card",
        ],
        "btn" => "Cancel",
        "new" => "New request",
    ],
    "your_paysafecard" => "Your transfers",
];