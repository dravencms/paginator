<?php

namespace Dravencms\Paginator\DI;

use Kdyby\Translation\DI\ITranslationProvider;
use Nette;
/**
 * Class AdminExtension
 * @package Dravencms\Admin\DI
 */
class PaginatorExtension extends Nette\DI\CompilerExtension implements ITranslationProvider
{
    public function getTranslationResources()
    {
        return [__DIR__.'/../lang'];
    }
}
