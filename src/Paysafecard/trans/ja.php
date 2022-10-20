<?php
return [
    'paysafecard' => [
        'success' => "クレジットを受け取るために確認されている転送.",
        'cancel' => "資金移動がキャンセルされました.",
        'accept' => "転送が正常に受け入れられました.",
        'refuse' => "転送が正常に拒否されました.",
        'change' => "変更されたカードの値.",
        "form" => [
            "pin" => "ピンコード",
            "value" => "カードの価値",
            "giveback" => "返却されたクレジット",
            "submit" => "送信",
        ],
        "states" => [
            "Pending" => "進行中",
            "Accepted" => "承認済み",
            "Refused" => "拒否した",
            "Cancelled" => "キャンセル",
        ],
        "admin" => [
            "title" => "ペイセーフカード転送",
            "subtitle" => "クレジットへのPaysafecard転送を管理する.",
            "warning" => "カードの確認が完了すると、値がアカウントに直接追加されます. <br/> 最初のボタンはコードをキャンセルし、2番目のボタンはコードを受け入れ、3番目のボタンはコードを拒否します.",
            "check" => "カードを確認してください",
        ],
        "btn" => "キャンセルします",
        "new" => "新しいリクエスト",
    ],
    "your_paysafecard" => "Paysafecardの送金",
];