<?php

namespace Service\Sorter;


interface ISorter
{
    /**
     * @param array $array
     * @return array
     */
    public function sort(array $array): array;
}