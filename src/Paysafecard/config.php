<?php

use App\Paysafecard\PaysafecardPaymentType;
use App\Paysafecard\Navigations\Items\PaysafecardCustomerItem;
use App\Paysafecard\Extensions\PaysafecardTwigExtension;
use App\Paysafecard\Navigations\Items\PaysafecardAdminItem;

use ClientX\Navigation\DefaultMainItem;
use function DI\add;
use function DI\get;
return [
<<<<<<< HEAD
    'navigation.main.items' => add([get(PaysafecardMainItem::class)]),
    'twig.extensions' => add([get(PaysafecardTwigExtension::class)]),
    'admin.customer.items' => add([get(PaysafecardCustomerItem::class)]),
    'payments.type' => add([get(PaysafecardPaymentType::class)]),
=======
    'navigation.main.items' => add([new DefaultMainItem([DefaultMainItem::makeItem('Paysafecard', 'paysafecard.index', 'fa fa-credit-card')], 80)]),
    'twig.extensions'       => add([get(PaysafecardTwigExtension::class)]),
    'admin.customer.items'  => add([get(PaysafecardCustomerItem::class)]),
    'payments.type'         => add([get(PaysafecardPaymentType::class)]),
    'admin.menu.items'      => add([get(PaysafecardAdminItem::class)]),
>>>>>>> 79d4bd7567d359f1b5870082663d09fff908b805
];
