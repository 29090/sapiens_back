<?php

namespace App\Services\UserSettings;

use App\Models\Difficulty;
use App\Models\Language;
use App\Models\UserSettings;
use App\Services\Video\VideoService;
use Illuminate\Http\Request;

class UpdateService
{
    public function __construct(
        private Request $request,
        private UserSettings $userSettings,
        private VideoService $videoService,
        private UserSettingsService $userSettingsService
    ) {}

    public function run() 
    {
        $this->userSettings->fill(
            $this->request->only(
                'language_id',
                'difficulty_id'
            )
        );

        $this->userSettings->save();

        $this->userSettingsService->setBorders($this->userSettings);
    }
}