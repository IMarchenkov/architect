<?php

namespace Service\Sorter;

use Model\Entity\Product;

class NameSorter implements ISorter
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
        $price1 = strtolower($prod1->getName());
        $price2 = strtolower($prod2->getName());

        if($price1 == $price2)
            return 0;

        return $price1 > $price2 ? 1 : -1;
    }
}