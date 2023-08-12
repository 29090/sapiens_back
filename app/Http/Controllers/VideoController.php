<?php

namespace App\Http\Controllers;

use App\Models\UserSettings;
use App\Services\Video\VideoService;

class VideoController extends Controller
{
    public function __construct(
        private VideoService $videoService
    )
    {
    }

    public function index(UserSettings $userSettings)
    {
        $difficulty = $userSettings->difficulty;
        $language = $userSettings->language;
        
        $bottomBorder = $userSettings->bottom_border;
        $topBorder = $userSettings->top_border;
        $step = $difficulty->pictures_per_day;
        $user = auth()->user();

        $progress = $user->progress;

        $videoLinks = $this->videoService->getVideoLinks($language);
        $videosToShow = array_slice($videoLinks, $bottomBorder + $progress * $step, $step);

        $progress++;
        if ($progress >= ($topBorder - $bottomBorder) / $step) {
            $user->progress = 0;
        } else {
            $user->progress = $progress;
        }
        $user->save();

        return response()->json($videosToShow);
    }
}
