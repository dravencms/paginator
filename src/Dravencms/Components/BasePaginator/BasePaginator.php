<?php declare(strict_types = 1);

namespace Dravencms\Components\BasePaginator;

use Dravencms\Components\BaseControl\BaseControl;
use IPub\VisualPaginator\Components\Control;
use Nette\ComponentModel\IContainer;
use Nette\Localization\ITranslator;

/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */
class BasePaginator extends BaseControl
{
    /** @var ITranslator */
    private $translator;

    public function __construct(ITranslator $translator = null)
    {
        $this->translator = $translator;
    }

    public function render(): void
    {
        $template = $this->template;
        $template->activeLocales = $this->localeRepository->getActive();
        $template->fileSelectorPath = $this->fileFile->getFileSelectorPath();
        $template->setFile(__DIR__ . '/DownloadFileForm.latte');
        $template->render();
    }
    
    /**
     * @param IContainer $container
     * @param $name
     * @return Grid
     */
    /*public function create(IContainer $container = null, string $name = null)
    {
        $control = new Control();
        $control->setTemplateFile(__DIR__.'/bootstrap-localized.latte');

        return $control;
    }*/

}