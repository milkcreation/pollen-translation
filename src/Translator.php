<?php

declare(strict_types=1);

namespace Pollen\Translation;

use BadMethodCallException;
use Exception;
use Pollen\Support\Concerns\ConfigBagAwareTrait;
use Pollen\Support\Proxy\ContainerProxy;
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
    use ContainerProxy;

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

    /**
     * Appel des méthodes du gestionnaire de traduction délégué.
     *
     * @param string $method
     * @param array $arguments
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function __call(string $method, array $arguments)
    {
        try {
            return $this->delegateTranslator->{$method}(...$arguments);
        } catch (Exception $e) {
            throw $e;
        } catch (Throwable $e) {
            throw new BadMethodCallException(
                sprintf(
                    'Default Translator method call [%s] throws an exception: %s',
                    $method,
                    $e->getMessage()
                ), 0, $e
            );
        }
    }

    public function addArrayLoader(string $name): TranslatorInterface
    {
        $this->addLoader($name, new ArrayLoader());

        return $this;
    }

}