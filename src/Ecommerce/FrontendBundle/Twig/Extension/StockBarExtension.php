<?php
namespace Ecommerce\FrontendBundle\Twig\Extension;

use Ecommerce\ItemBundle\Entity\Item;
use Ecommerce\FrontendBundle\Twig\Extension\CustomTwigExtension;

class StockBarExtension extends CustomTwigExtension
{
    public function getFunctions()
    {
        return array('drawStockBar' => new \Twig_Function_Method($this, 'drawStockBar'));
    }

    public function drawStockBar($stockLevel)
    {
        $progressBarClass = $this->_getStockBarClass($stockLevel);
        $out = '<div class="progress">' .
                    '<div class="progress-bar ' . $progressBarClass . '" role="progressbar" aria-valuenow="' . $stockLevel . '" aria-valuemin="0" aria-valuemax="100" style="width: ' . $stockLevel . '%">
                    </div>
                </div>';

        echo $out;
    }

    private function _getStockBarClass($stockLevel){
        if ($stockLevel == Item::HIGH_STOCK || $stockLevel == Item::MEDIUM_STOCK) {
            return 'progress-bar-success';
        } else {
            if ($stockLevel == Item::LOW_STOCK) {
                return 'progress-bar-warning';
            } else {
                return 'progress-bar-danger';
            }
        }
    }

    public function getName()
    {
        return 'stockbar_extension';
    }
}