<?php

namespace Framework\Command;


interface ICommand
{
    public function execute(array $params): array ;
}