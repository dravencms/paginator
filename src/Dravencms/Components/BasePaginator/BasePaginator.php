<?php

declare(strict_types=1);

namespace Dravencms\Components\BasePaginator;

use Dravencms\Components\BaseControl\BaseControl;
use Nette\Localization\ITranslator;
use Nette\Utils\Paginator;

/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */
class BasePaginator extends BaseControl {

    /**
     * @persistent int
     */
    public $page = 1;

    /**
     * Event on show page
     * @var array
     */
    public $onShowPage;

    /** @var ITranslator */
    private $translator;

    /** @var string */
    private $templateFile;

    /** @var int */
    private $displayRelatedPages = 3;

    /** @var bool */
    private $useAjax = true;

    /** @var Paginator */
    private $paginator;

    /**
     * @param ITranslator $translator
     */
    public function __construct(ITranslator $translator = null) {
        $this->translator = $translator;
        $this->paginator = new Paginator();
    }

    /**
     * @param string $templateFile
     * @return BasePaginator
     * @throws \Exception
     */
    public function setTemplateFile(string $templateFile): BasePaginator {
        if (!is_file($templateFile)) {
            throw new \Exception('Template file "' . $templateFile . '" was not found.');
        }

        $this->templateFile = $templateFile;

        return $this;
    }

    /**
     * @return BasePaginator
     */
    public function enableAjax(): BasePaginator {
        $this->useAjax = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function disableAjax(): BasePaginator {
        $this->useAjax = false;
        return $this;
    }

    /**
     * @return Paginator
     */
    public function getPaginator(): Paginator {
        return $this->paginator;
    }

    /**
     * @return array
     */
    private function getSteps() {

        // Get actual paginator page
        $page = $this->paginator->page;

        if ($this->paginator->pageCount < 2) {
            $steps = [$page];
        } else {
            $relatedPages = $this->displayRelatedPages ?: 3;
            $arr = range(max($this->paginator->firstPage, $page - $relatedPages), min($this->paginator->lastPage, $page + $relatedPages));
            $count = 4;
            $quotient = ($this->paginator->pageCount - 1) / $count;

            for ($i = 0; $i <= $count; $i++) {
                $arr[] = round($quotient * $i) + $this->paginator->firstPage;
            }

            sort($arr);

            $steps = array_values(array_unique($arr));
        }

        return $steps;
    }

    /**
     * @return void
     */
    public function render(): void {
        $template = $this->template;
        $template->setTranslator($this->translator);
        $template->steps = $this->getSteps();
        $template->paginator = $this->getPaginator();
        $template->handle = 'showPage!';
        $template->useAjax = $this->useAjax;

        if ($this->template->getFile() === null) {
            $templateFile = !empty($this->templateFile) ? $this->templateFile : __DIR__ . '/bootstrap-localized.latte';
            $this->template->setFile($templateFile);
        }

        // Render component template
        $this->template->render();
    }

    /**
     * @param array $params
     * @return void
     */
    public function loadState(array $params): void {
        parent::loadState($params);

        $this->paginator->page = $this->page;
    }

    /**
     * @param int $page
     */
    public function handleShowPage($page) {
        $this->onShowPage($this, $page);
    }

}
