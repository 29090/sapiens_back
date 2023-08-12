<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\UserSettings\UserSettingsService;
use App\Services\Video\VideoService;
use Illuminate\Console\Command;

class MoveBordersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-settings:move-borders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(VideoService $videoService, UserSettingsService $userSettingsService)
    {
        $users = User::all();

        foreach ($users as $user) {
            $userSettings = $user->user_settings;
            if (is_null($userSettings)) {
                continue;
            }

            if (is_null($userSettings->bottom_border) || is_null($userSettings->top_border)) {
                $userSettingsService->setBorders($userSettings);
                
                continue;
            }

            $difficulty = $userSettings->difficulty;
            $videoLinks = $videoService->getVideoLinks($userSettings->language);

            $oldBottomBorder = $userSettings->bottom_border;
            $oldTopBorder = $userSettings->top_border;

            $newBottomBorder = 0;
            $newTopBorder = 0;

            // следущий шаг не перескочет конец папки как обычно прибавляем step
            if (count($videoLinks) >= $oldTopBorder + $difficulty->pictures_per_day) {
                $newTopBorder = $oldTopBorder + $difficulty->pictures_per_day;
                $newBottomBorder = $oldBottomBorder + $difficulty->pictures_per_day;
            } else {
                // если следующий шаг перескочет конец папки то сдвигаем пределы на начальное положение
                $userSettingsService->setBorders($userSettings);
                continue;
            }

            $userSettings->bottom_border = $newBottomBorder;
            $userSettings->top_border = $newTopBorder;
            $userSettings->save();

            $user = $userSettings->user;
            $user->progress = 0;
            $user->save();
        }
    }
}
