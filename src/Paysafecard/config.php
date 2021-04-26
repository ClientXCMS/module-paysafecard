<?php

use App\Paysafecard\PaysafecardPaymentType;
use App\Paysafecard\Navigations\Items\PaysafecardCustomerItem;
use App\Paysafecard\Navigations\Items\PaysafecardMainItem;
use App\Paysafecard\Extensions\PaysafecardTwigExtension;
use App\Paysafecard\Navigations\Items\PaysafecardAdminItem;

use function DI\add;
use function DI\get;

return [
    'navigation.main.items' => add([get(PaysafecardMainItem::class)]),
    'twig.extensions'       => add([get(PaysafecardTwigExtension::class)]),
    'admin.customer.items'  => add([get(PaysafecardCustomerItem::class)]),
    'payments.type'         => add([get(PaysafecardPaymentType::class)]),
    'admin.menu.items'      => add([get(PaysafecardAdminItem::class)]),

];
