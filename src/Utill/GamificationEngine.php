<?php

namespace App\Util;

use App\Entity\User;

class GamificationEngine
{
    /**
     * Calcul de l'expérience nécessaire pour atteindre un niveau donné.
     */
    public static function computeExperienceNeededForLevel(int $level): int
    {
        return $level * ($level - 1) * 100 / 2;
    }

    /**
     * Calcul du niveau pour un utilisateur.
     */
    public static function computeLevelForUser(User $user): int
    {
        $exp = $user->getExperience();
        $level = (0.5 + sqrt(1 + 8 * $exp / 100) / 2);

        return (int) $level;
    }

    /**
     * Calcul du pourcentage d'avancement pour monter au niveau suivant.
     */
    public static function computeLevelCompletionForUser(User $user): int
    {
        $level = $user->getLevel();
        $exp = $user->getExperience();

        $expCurrentLevel = self::computeExperienceNeededForLevel($level);
        $expNextLevel = self::computeExperienceNeededForLevel($level + 1);

        return ($exp - $expCurrentLevel) / ($expNextLevel - $expCurrentLevel) * 100;
    }
}
