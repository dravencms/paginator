<?php declare(strict_types = 1);

namespace Dravencms\Paginator\DI;

use Contributte\Translation\DI\TranslationProviderInterface;
use Nette\DI\CompilerExtension;

/**
 * Class AdminExtension
 * @package Dravencms\Admin\DI
 */
class PaginatorExtension extends CompilerExtension implements TranslationProviderInterface
{
    public function loadConfiguration(): void
    {
        $this->loadComponents();
    }
    
    protected function loadComponents(): void
    {
        $builder = $this->getContainerBuilder();
        foreach ($this->loadFromFile(__DIR__ . '/components.neon') as $i => $command) {
            $cli = $builder->addFactoryDefinition($this->prefix('components.' . $i));
            if (is_string($command)) {
                $cli->setImplement($command);
            } else {
                throw new \InvalidArgumentException;
            }
        }
    }
    
    public function getTranslationResources(): array
    {
        return [__DIR__.'/../lang'];
    }
    
}
