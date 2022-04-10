<?php

use App\Paysafecard\PaysafecardPaymentType;
use App\Paysafecard\Navigations\Items\PaysafecardCustomerItem;
use App\Paysafecard\Extensions\PaysafecardTwigExtension;
use App\Paysafecard\Navigations\Items\PaysafecardFundItem;
use App\Paysafecard\Navigations\Items\PaysafecardWidget;
use App\Paysafecard\PaysafecardPaymentBoard;
use function DI\add;
use function DI\get;
return [
    'twig.extensions'       => add([get(PaysafecardTwigExtension::class)]),
    'admin.customer.items'  => add([get(PaysafecardCustomerItem::class)]),
    'payments.type'         => add([get(PaysafecardPaymentType::class)]),
    'payment.boards'        => add(get(PaysafecardPaymentBoard::class)),
    'admin.dashboard.items' => add(get(PaysafecardWidget::class)),
    'addfund.types'         => add(get(PaysafecardFundItem::class)),
];
