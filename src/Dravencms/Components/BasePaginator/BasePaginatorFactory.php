<?php declare(strict_types = 1);
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Dravencms\Components\BasePaginator;

use Nette\ComponentModel\IContainer;

interface BasePaginatorFactory
{
    /**
     * @param IContainer $container
     * @param $name
     * @return BasePaginator
     */
    public function create(): BasePaginator;
}