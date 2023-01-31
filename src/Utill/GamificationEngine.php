<?php

namespace App\Util;

use App\Entity\User;

class GamificationEngine
{
    public static function computeExperienceNeededForLevel(int $level): int
    {
        return $level * ($level - 1) * 100 / 2;
    }

    public static function computeLevelForUser(User $user): int
    {
        $exp = $user->getExperience();
        $level = (0.5 + sqrt(1 + 8 * $exp / 100) / 2);

        return (int) $level;
    }

    // public static function computeLevelCompletionForUser(User $user): int
    // {
    //     $currentlevel = self::computeExperienceNeededForLevel($user->getLevel());
    //     $nextLevel = self::computeExperienceNeededForLevel($user->getLevel() + 1);
    //     return ($user->getExperience() - $currentlevel) / ($nextLevel - $currentlevel) * 100;
    // }
}
