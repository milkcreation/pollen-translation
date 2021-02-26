<?php

declare(strict_types=1);

namespace Pollen\Translation\Concerns;

use InvalidArgumentException;
use Pollen\Translation\LabelsBag;

interface LabelsBagAwareTraitInterface
{
    /**
     * Liste des intitulés par défaut.
     *
     * @return array
     */
    public function defaultLabels(): array;

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
    public function labels($key = null, $default = '');

    /**
     * Traitement de la liste des intitulés.
     *
     * @return void
     */
    public function parseLabels(): void;

    /**
     * Définition de la liste des intitulés.
     *
     * @param array $labels
     *
     * @return LabelsBagAwareTrait
     */
    public function setLabels(array $labels): LabelsBagAwareTrait;
}