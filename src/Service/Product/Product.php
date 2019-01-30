<?php

declare(strict_types = 1);

namespace Service\Product;

use Model;
use Service\Sorter\ISorter;
use Service\Sorter\NameSorter;
use Service\Sorter\PriceSorter;

class Product
{
    /**
     * Получаем информацию по конкретному продукту
     *
     * @param int $id
     * @return Model\Entity\Product|null
     */
    public function getInfo(int $id): ?Model\Entity\Product
    {
        $product = $this->getProductRepository()->search([$id]);
        return count($product) ? $product[0] : null;
    }

    /**
     * Получаем все продукты
     *
     * @param string $sortType
     *
     * @return Model\Entity\Product[]
     */
    public function getAll(string $sortType): array
    {
        $productList = $this->getProductRepository()->fetchAll();

        // Применить паттерн Стратегия
        switch ($sortType) {
            // $sortType === 'price'; // Сортировка по цене
            case 'price':
                $productList = $this->sort(new PriceSorter(), $productList);
                break;
            // $sortType === 'name'; // Сортировка по имени
            case 'name':
                $productList = $this->sort(new NameSorter(), $productList);
                break;
        }
        return $productList;
    }

    /**
     * Фабричный метод для репозитория Product
     *
     * @return Model\Repository\Product
     */
    protected function getProductRepository(): Model\Repository\Product
    {
        return new Model\Repository\Product();
    }

    /**
     * Реализация стратегии
     *
     * @param ISorter $sorter
     * @param array $array
     * @return $array
     */
    protected function sort(ISorter $sorter, $array){
        return $sorter->sort($array);
    }
}
