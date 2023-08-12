<?php

use App\Http\Controllers\LicenseAgreementController;

Route::get('/license-agreement', [LicenseAgreementController::class, 'index']);
