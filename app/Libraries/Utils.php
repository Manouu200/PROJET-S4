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

    /**
     * Retourne la plage de poids idéale selon l'IMC normal
     * (18.5 -> 24.9)
     *
     * @param float $tailleCm Taille en centimètres
     * @return array
     */
    public static function poidsIdealInterval(float $tailleCm): array
    {
        if ($tailleCm <= 0) {
            return [
                'min' => 0,
                'max' => 0
            ];
        }

        // Conversion cm -> m
        $tailleMetre = $tailleCm / 100;

        // IMC normal OMS
        $imcMin = 18.5;
        $imcMax = 24.9;

        // Calculs
        $poidsMin = $imcMin * ($tailleMetre * $tailleMetre);
        $poidsMax = $imcMax * ($tailleMetre * $tailleMetre);

        return [
            'min' => round($poidsMin),
            'max' => round($poidsMax)
        ];
    }

    /**
     * Retourne le poids idéal moyen
     * basé sur un IMC moyen sain (~21.7)
     *
     * @param float $tailleCm Taille en centimètres
     * @return float
     */
    public static function poidsIdeal(float $tailleCm): float
    {
        if ($tailleCm <= 0) {
            return 0;
        }

        // Conversion cm -> m
        $tailleMetre = $tailleCm / 100;

        // IMC moyen "idéal"
        $imcIdeal = 21.7;

        // Calcul
        $poidsIdeal = $imcIdeal * ($tailleMetre * $tailleMetre);

        return round($poidsIdeal);
    }
}
