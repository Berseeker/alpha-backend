<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class DashboardController extends ApiController
{
    public function index()
    {
        return $this->successResponse('Necesitas estar logueado para acceder aqui',null,200);
    }
}
