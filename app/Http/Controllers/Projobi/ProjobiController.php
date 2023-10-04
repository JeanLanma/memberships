<?php

namespace App\Http\Controllers\Projobi;

use App\Services\Projobi\GetProjobiUserService;
use App\Http\Controllers\Controller;
use App\Services\Projobi\UpdateProjobiUserService;
use Illuminate\Http\Request;

class ProjobiController extends Controller
{
    public function index()
    {
        return GetProjobiUserService::get();
    }

    public function getUserById($id)
    {
        return GetProjobiUserService::getUserById($id);
    }
}
