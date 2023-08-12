<?php

namespace App\Services\UserSettings;

use App\Models\UserSettings;
use App\Services\Video\VideoService;
use Illuminate\Http\Request;

class UserSettingsService
{
    public function __construct(
        private VideoService $videoService
    ) {}

    public function setBorders(UserSettings $userSettings): void
    {
        $language = $userSettings->language;
        $difficulty = $userSettings->difficulty;

        $videoFiles = $this->videoService->getVideoLinks($language);
        
        $maxFilesPerDay = $difficulty->max_files_per_day;
        
        $bottomBorder = 0;
        if (count($videoFiles) < $maxFilesPerDay) {
            $topBorder = count($videoFiles);
        } else {
            $topBorder = $maxFilesPerDay;
        }

        $userSettings->bottom_border = $bottomBorder;
        $userSettings->top_border = $topBorder;
        $userSettings->save();

        $user = $userSettings->user;
        $user->progress = 0;
        $user->save();
    }
}