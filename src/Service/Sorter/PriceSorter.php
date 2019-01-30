<?php

namespace Service\Sorter;

use Model\Entity\Product;

class PriceSorter implements ISorter
{
    /**
     * @param array $array
     * @return array
     */
    public function sort(array $array): array
    {

        usort($array, [$this, 'compare']);

        return $array;
    }

    /**
     * @param Product $prod1
     * @param Product $prod2
     * @return int
     */
    protected function compare(Product $prod1, Product $prod2): int
    {
        $price1 = $prod1->getPrice();
        $price2 = $prod2->getPrice();

        if($price1 == $price2)
            return 0;

        return $price1 > $price2 ? 1 : -1;
    }
}