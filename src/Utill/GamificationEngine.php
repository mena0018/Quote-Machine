<?php

namespace App\Util;

use App\Entity\User;

class GamificationEngine
{
  public static function computeLevelForUser(User $user): int
  {
    return 5;
  }

  public static function computeExperienceNeededForLevel(int $level): int
  {
    return 5;
  }

  public static function computeLevelCompletionForUser(User $user): int|float
  {
    return 5;
  }
}