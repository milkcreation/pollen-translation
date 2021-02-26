<?php

declare(strict_types=1);

namespace Pollen\Translation\Concerns;

use InvalidArgumentException;
use Pollen\Translation\LabelsBag;

/**
 * @see \Pollen\Translation\Concerns\LabelsBagAwareTraitInterface
 */
trait LabelsBagAwareTrait
{
    /**
     * Instance du gestionnaire d'intitulés.
     * @var LabelsBag|null
     */
    protected $labelsBag;

    /**
     * Liste des intitulés par défaut.
     *
     * @return array
     */
    public function defaultLabels(): array
    {
        return [];
    }

    /**
     * Définition|Récupération|Instance des intitulés.
     *
     * @param array|string|null $key
     * @param mixed $default
     *
     * @return string|array|mixed|LabelsBag
     *
     * @throws InvalidArgumentException
     */
    public function labels($key = null, $default = '')
    {
        if (!$this->labelsBag instanceof LabelsBag) {
            $this->labelsBag = LabelsBag::createFromAttrs($this->defaultLabels());
        }

        if (is_null($key)) {
            return $this->labelsBag;
        }
        if (is_string($key)) {
            return $this->labelsBag->get($key, $default);
        }
        if (is_array($key)) {
            return $this->labelsBag->set($key);
        }
        throw new InvalidArgumentException('Invalid LabelsBag passed method arguments');
    }

    /**
     * Traitement de la liste des intitulés.
     *
     * @return void
     */
    public function parseLabels(): void
    {
    }

    /**
     * Définition de la liste des intitulés.
     *
     * @param array $labels
     *
     * @return static
     */
    public function setLabels(array $labels): LabelsBagAwareTrait
    {
        $this->labels($labels);

        return $this;
    }
}