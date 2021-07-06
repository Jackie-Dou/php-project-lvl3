<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class UrlController extends Controller
{
    public function index()
    {
        $urls = Url::all();
        return view('urls.index', compact('urls'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $this->validate($request, [
                'name' => 'required|max:255|url',
            ]);
        } catch (ValidationException $e) {
            flash($e->getMessage())->error();
            return redirect()
                ->route('home');
        }
        try {
            $data = $this->validate($request, [
                'name' => 'unique:urls',
            ]);
        } catch (ValidationException $e) {
            flash('This url already exists')->warning();
            return redirect()
                ->route('home');
        }

        $url = new Url();
        $url->fill($data);
        $url->created_at = Carbon::now();
        $url->updated_at = Carbon::now();

        $url->save();
        flash('Url was added successfully')->success();
        return redirect()
            ->route('urls.show', $url->id);
    }

    public function show($id)
    {
        $url = Url::findOrFail($id);
        return view('urls.show', compact('url'));
    }

}
