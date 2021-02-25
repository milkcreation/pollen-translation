<?php

declare(strict_types=1);

namespace Pollen\Translation;

use BadMethodCallException;
use Pollen\Support\Concerns\ParamsBagAwareTrait;
use Pollen\Support\Str;
use Throwable;

/**
 * @mixin \Pollen\Support\ParamsBag
 */
class LabelsBag implements LabelsBagInterface
{
    use ParamsBagAwareTrait;

    /**
     * Indicateur de gestion du féminin.
     * @var boolean
     */
    protected $gender = false;

    /**
     * Nom de qualification.
     * @var string
     */
    protected $name = '';

    /**
     * Intitulé de qualification du pluriel d'un élément.
     * @var string
     */
    protected $plural = '';

    /**
     * Intitulé de qualification du singulier d'un élément.
     * @var string
     */
    protected $singular = '';

    /**
     * @inheritDoc
     */
    public function __call(string $method, array $arguments)
    {
        try {
            return $this->params()->{$method}(...$arguments);
        } catch (Throwable $e) {
            throw new BadMethodCallException(
                sprintf(
                    'LabelsBag method call [%s] throws an exception: %s',
                    $method,
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * Création d'une instance.
     *
     * @param array $labels
     * @param string|null $name
     *
     * @return LabelsBagInterface
     */
    public static function create(array $labels, ?string $name = null): LabelsBagInterface
    {
        $self = new static();

        if (!is_null($name)) {
            $self->setName($name);
        }

        $self->params($labels)->parseLabels();

        if ($self->has('gender')) {
            $self->setGender((bool)$self->pull('gender'));
        }

        if ($self->has('plural')) {
            $self->setPlural(lcfirst($self->pull('plural')));
        }

        if ($self->has('singular')) {
            $self->setSingular(lcfirst($self->pull('singular')));
        }

        return $self;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function gender(): bool
    {
        return $this->gender;
    }

    /**
     * @inheritDoc
     */
    public function plural(bool $ucFirst = false): string
    {
        $str = $this->plural ?: 'éléments';

        return $ucFirst ? Str::ucfirst($str) : $str;
    }

    /**
     * @inheritDoc
     */
    public function pluralDefinite(bool $contraction = false): string
    {
        if ($contraction) {
            return 'des ' . $this->plural();
        }

        return 'les '. $this->plural();
    }

    /**
     * @inheritDoc
     */
    public function pluralIndefinite(): string
    {
        $prefix = $this->useVowel() ? 'd\'' : 'des ';

        return $prefix . $this->plural();
    }

    /**
     * @inheritDoc
     */
    public function singular(bool $ucFirst = false): string
    {
        $str = $this->singular ?: 'élément';

        return $ucFirst ? Str::ucfirst($str) : $str;
    }

    /**
     * @inheritDoc
     */
    public function singularDefinite(bool $contraction = false): string
    {
        if ($contraction) {
            if ($this->useVowel()) {
                $prefix = 'de l\'';
            } else {
                $prefix = $this->gender() ? 'de la ' : 'du ';
            }

            return $prefix . $this->singular();
        }
            if ($this->useVowel()) {
                $prefix = 'l\'';
            } else {
                $prefix = $this->gender() ? 'la ' : 'le ';
            }

            return $prefix . $this->singular();
    }

    /**
     * @inheritDoc
     */
    public function singularIndefinite(): string
    {
        $prefix = $this->gender() ? 'une' : 'un';

        return $prefix . ' ' . $this->singular();
    }

    /**
     * @inheritDoc
     */
    public function setGender(bool $gender): LabelsBagInterface
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): LabelsBagInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setPlural(string $plural): LabelsBagInterface
    {
        $this->plural = $plural;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function setSingular(string $singular): LabelsBagInterface
    {
        $this->singular = $singular;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function useVowel(): bool
    {
        $first = strtolower(mb_substr(remove_accents($this->singular()), 0, 1));

        return in_array($first, ['a', 'e', 'i', 'o', 'u', 'y']);
    }
}