<?php

use App\Paysafecard\PaysafecardPaymentType;
use App\Paysafecard\Navigations\Items\PaysafecardCustomerItem;
use App\Paysafecard\Extensions\PaysafecardTwigExtension;

use ClientX\Navigation\DefaultMainItem;
use function DI\add;
use function DI\get;
return [
    'navigation.main.items' => add([new DefaultMainItem([DefaultMainItem::makeItem('Paysafecard', 'paysafecard.index', 'fa fa-credit-card')], 80)]),
    'twig.extensions'       => add([get(PaysafecardTwigExtension::class)]),
    'admin.customer.items'  => add([get(PaysafecardCustomerItem::class)]),
    'payments.type'         => add([get(PaysafecardPaymentType::class)])
];
