<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConvertRequest;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function convert(ConvertRequest $request)
    {
        return $request->validated();
    }
}
