<?php

namespace App\Util;

class GamificationEngine
{
    public static function computeExperienceNeededForLevel(int $level): int
    {
        return $level * ($level - 1) * 100 / 2;
    }
}
