<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSettings\UpdateRequest;
use App\Services\UserSettings\UpdateService;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserSettingsController extends Controller
{
    public function update(UpdateRequest $request, UpdateService $updateService) 
    {
        DB::beginTransaction();
        try {

            $updateService->run($request);

            DB::commit();
            return response();

        } catch (Throwable $exception) {

            DB::rollBack();
            throw $exception;
        }
    }
}
