<?php
return [
    'paysafecard' => [
        'success' => "Recibida el credito en cuanto la transferencia sea verificada.",
        'cancel' => "Transferencia de fondos anulada.",
        'accept' => "Transferencia aceptada con éxito.",
        'refuse' => "Transferencia rechazada con éxito.",

        'change' => "Valor de la tarjeta cambiado.",
        "form" => [
            "pin" => "Código PIN",
            "value" => "Valor de la tarjeta",
            "giveback" => "Devolución de créditos",
            "submit" => "Enviar",
        ],
        "states" => [
            "Pending" => "Pendiente",
            "Accepted" => "Aceptado",
            "Refused" => "Rechazado",
            "Cancelled" => "Cancelado",
        ],
        "admin" => [
            "title" => "Transferencias de Paysafecard",
            "subtitle" => "Gestor de transferencias de Paysafecard a Crédito.",
            "warning" => "Una vez confirmada la tarjeta, la devolución se añadirá directamente a la cuenta. <br/> El primer botón cancela el código, el segundo lo acepta y el tercero lo rechaza.",
            "check" => "Comprobar una tarjeta",
        ],
        "btn" => "Cancelar",
        "new" => "Nueva solicitud",
    ],
    "your_paysafecard" => "Tus transferencias de Paysafecard",
];