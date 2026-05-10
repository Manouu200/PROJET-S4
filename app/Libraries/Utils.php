<?php

namespace App\Libraries;

use App\Models\IMCModel;

class Utils
{
    /**
     * Calculer l'IMC
     *
     * @param float $poids Poids en kilogrammes
     * @param float $tailleCm Taille en centimètres
     * @return float
     */
    public static function calculerIMC(float $poids, float $tailleCm): float
    {
        // Sécurité pour éviter division par zéro
        if ($tailleCm <= 0) {
            return 0;
        }

        // Conversion cm -> m
        $tailleMetre = $tailleCm / 100;

        // Calcul IMC
        $imc = $poids / ($tailleMetre * $tailleMetre);

        // Arrondir à 1 chiffre après la virgule
        return round($imc, 1);
    }

    /**
     * Retourne la catégorie de l'IMC
     *
     * @param float $imc
     * @return string
     */
    public static function categorieIMC(float $imc): string
    {
        $imcModel = new IMCModel();
        $categorie = $imcModel->where('min <=', $imc)
            ->where('max >', $imc)
            ->first();

        if ($categorie) {
            return $categorie['libelle'];
        }

        return 'Inconnu';
    }
}
