<?php
namespace App\Paysafecard\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PaysafecardTwigExtension extends AbstractExtension
{

    public function getFilters()
    {
        return [
            new TwigFilter('paysafecard_status', [$this, 'getStatus'])
        ];
    }


    public function getStatus(int $status)
    {
        $class = null;
        $title = null;

        switch ($status) {
            case 0:
                $class = "warning";
                $title = "En attente";
                break;
            case 1:
                $class = "success";
                $title = "Acceptée";
                break;
            case 2:
                $class = "danger";
                $title = "Refusée";
                break;
            default:
                $class = "danger";
                $title = "ERROR";
        }
        return  sprintf("<span class='badge badge-%s'>%s</span>", $class, $title);
    }
}
