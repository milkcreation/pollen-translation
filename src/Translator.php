<?php

declare(strict_types=1);

namespace Pollen\Translation;

use BadMethodCallException;
use Pollen\Support\Concerns\ConfigBagAwareTrait;
use Pollen\Support\Concerns\ContainerAwareTrait;
use Psr\Container\ContainerInterface as Container;
use Symfony\Component\Translation\Translator as DelegateTranslator;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Throwable;

/**
 * @mixin DelegateTranslator
 */
class Translator implements TranslatorInterface
{
    use ConfigBagAwareTrait;
    use ContainerAwareTrait;

    /**
     * @var DelegateTranslator
     */
    protected $delegateTranslator;

    /**
     * @param array $config
     * @param Container|null $container
     */
    public function __construct(array $config = [], ?Container $container = null)
    {
        $this->setConfig($config);

        if (!is_null($container)) {
            $this->setContainer($container);
        }

        $this->delegateTranslator = new DelegateTranslator('fr_FR');
    }


    public function __call(string $method, array $arguments)
    {
        try {
            return $this->delegateTranslator->{$method}(...$arguments);
        } catch (Throwable $e) {
            throw new BadMethodCallException(
                sprintf(
                    'Default Translator method call [%s] throws an exception: %s',
                    $method,
                    $e->getMessage()
                )
            );
        }
    }

    public function addArrayLoader(string $name): TranslatorInterface
    {
        $this->addLoader($name, new ArrayLoader());

        return $this;
    }

}