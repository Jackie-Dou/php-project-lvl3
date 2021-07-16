<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\UrlCheck;
use Illuminate\Http\Request;
use App\Http\Middleware\VerifyCsrfToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UrlController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $urls = Url::all();
        $lastChecks = DB::table('url_checks')
            ->orderBy('created_at')
            ->get()
            ->keyBy('url_id');
        // Метод keyBy() возвращает коллекцию по указанному ключу.
        // Если несколько элементов имеют одинаковый ключ, в результирующей коллекции появится только последний их них.
        return view('urls.index', compact('urls', 'lastChecks'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = parse_url($request->input('url.name'));
        $url = [];
        $url['name'] = ($data['scheme'] ?? '') . '://' . ($data['host'] ?? '');

        $validatorUrl = Validator::make($url, [
            'name' => 'required|max:255|url',
        ])->validate();

        $validatorUnique = Validator::make($url, [
            'name' => 'unique:urls,name',
        ]);
        if ($validatorUnique->fails()) {
            flash('This url already exists')->warning();
            return redirect()
                ->route('home');
        }

        $id = DB::table('urls')->insertGetId([
            'name' => $url['name'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        flash('Url was added successfully')->success();
        return redirect()
            ->route('urls.show', $id);
    }

    public function show($id)
    {
        $url = Url::findOrFail($id);
        $url_checks = UrlCheck::where('url_id', $id)->get();
        return view('urls.show', compact('url', 'url_checks'));
    }
}
