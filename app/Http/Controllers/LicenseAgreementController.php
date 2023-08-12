<?php

namespace App\Http\Controllers;

use App\Models\LicenseAgreement;
use Illuminate\Http\Request;

class LicenseAgreementController extends Controller
{
    public function index()
    {
        return response(LicenseAgreement::first());
    }
}
