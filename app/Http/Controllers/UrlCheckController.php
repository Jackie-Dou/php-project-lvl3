<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UrlCheckController extends Controller
{
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        return redirect()
            ->route('home');
    }
}
