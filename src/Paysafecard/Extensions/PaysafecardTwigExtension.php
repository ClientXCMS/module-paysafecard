<?php
namespace App\Paysafecard\Extensions;

use App\Paysafecard\Entity\Paysafecard;
use ClientX\Translator\Translater;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PaysafecardTwigExtension extends AbstractExtension
{
    private Translater $translater;
    public function __construct(Translater $translater)
    {
        $this->translater = $translater;
    }
    public function getFilters()
    {
        return [
            new TwigFilter('paysafecard_status', [$this, 'getStatus'])
        ];
    }


    public function getStatus(string $status)
    {
        $class = null;

        switch ($status) {
            case Paysafecard::PENDING:
                $class = "warning";
                break;
            case Paysafecard::ACCEPTED:

                $class = "success";
                break;
            case Paysafecard::REFUSED:

                $class = "danger";
                break;
            case Paysafecard::CANCELLED:

                $class = "primary";
                break;
            default:
                $class = "danger";
        }
        return  sprintf("<span class='badge badge-%s'>%s</span>", $class, $this->translater->trans("paysafecard.states." . $status));
    }
}
