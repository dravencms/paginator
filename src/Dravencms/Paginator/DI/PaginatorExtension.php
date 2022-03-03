<?php

namespace Dravencms\Paginator\DI;

use Contributte\Translation\DI\TranslationProviderInterface;
use Nette\DI\CompilerExtension;

/**
 * Class AdminExtension
 * @package Dravencms\Admin\DI
 */
class PaginatorExtension extends CompilerExtension implements TranslationProviderInterface
{
    public function getTranslationResources()
    {
        return [__DIR__.'/../lang'];
    }
}
