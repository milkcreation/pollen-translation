<?php

declare(strict_types=1);

namespace Pollen\Translation;

use Pollen\Support\Concerns\ParamsBagDelegateTraitInterface;

interface LabelsBagInterface extends ParamsBagDelegateTraitInterface
{
    /**
     * Récupération du nom de qualification.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Vérification du genre.
     *
     * @return boolean
     */
    public function gender(): bool;

    /**
     * Récupération du pluriel.
     *
     * @param boolean $ucFirst Mise en majuscule de la première lettre.
     *
     * @return string
     */
    public function plural(bool $ucFirst = false): string;

    /**
     * Récupération du pluriel précédé d'un article défini.
     *
     * @param boolean $contraction Activation de la forme contractée.
     *
     * @return string
     */
    public function pluralDefinite(bool $contraction = false): string;

    /**
     * Récupération du pluriel précédé d'un article indéfini.
     *
     * @return string
     */
    public function pluralIndefinite(): string;

    /**
     * Récupération du singulier.
     *
     * @param bool $ucFirst Mise en majuscule de la première lettre.
     *
     * @return string
     */
    public function singular(bool $ucFirst = false): string;

    /**
     * Récupération du singulier précédé d'un article défini.
     *
     * @param boolean $contraction Activation de la forme contractée.
     *
     * @return string
     */
    public function singularDefinite(bool $contraction = false): string;

    /**
     * Récupération du singulier précédé d'un article indéfini.
     *
     * @return string
     */
    public function singularIndefinite(): string;

    /**
     * Définition du genre de l'élément
     *
     * @param bool $gender
     *
     * @return static
     */
    public function setGender(bool $gender): LabelsBagInterface;

    /**
     * Définition du nom de qualification.
     *
     * @param string $name
     *
     * @return static
     */
    public function setName(string $name): LabelsBagInterface;

    /**
     * Définition de l'intitulé du pluriel d'un élément.
     *
     * @param string $plural
     *
     * @return static
     */
    public function setPlural(string $plural): LabelsBagInterface;

    /**
     * Définition de l'intitulé du singulier d'un élément.
     *
     * @param string $singular
     *
     * @return static
     */
    public function setSingular(string $singular): LabelsBagInterface;

    /**
     * Permet de vérifier si la première lettre d'une chaîne de caractère est une voyelle.
     *
     * @return bool
     */
    public function useVowel(): bool;
}