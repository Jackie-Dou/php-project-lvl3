<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Models\UrlCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class UrlController extends Controller
{
    public function index()
    {
//        $str = getenv("DB_CONNECTION");
//        if ($str !== false) {
//            Log::info($str);
//        } else {
//            Log::info("error!");
//        }

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
        var_dump("_______________________test_input_data______________________");
        var_dump($request->input());

//        $str = getenv("DB_CONNECTION");
//        if ($str !== false) {
//            Log::info($str);
//        } else {
//            Log::info("error!");
//        }

        $urls = Url::all();
        var_dump("_______________________show_all_url_in_table______________________");
        foreach ($urls as $url) {
            var_dump($url['id']);
            var_dump($url['name']);
        }
        var_dump("____________before_first_try_catch____________");


        $data = parse_url($request->input('url.name'));
        $url = [];
        $url['name'] = ($data['scheme'] ?? '') . '://' . ($data['host'] ?? '');

        try {
            $validator = Validator::make($url, [
                'name' => 'required|max:255|url',
            ])->validate();
        } catch (ValidationException $e) {
            flash($e->getMessage())->error();
            var_dump("____________trouble_in_first_catch____________");
            var_dump($e->getMessage());
            return redirect()
                ->route('home');
        }
        var_dump("____________before_second_try_catch____________");
        try {
            $validator = Validator::make($url, [
                'name' => 'unique:urls,name',
            ]);
        } catch (ValidationException $e) {
            flash('This url already exists')->warning();
            var_dump("____________trouble_in_second_catch____________");
            var_dump($e->getMessage());
            return redirect()
                ->route('home');
        }

        var_dump("____________before_inserting_in_DB____________");

        DB::table('urls')->insert([
            'name' => $url['name'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        var_dump("____________after_inserting_in_DB____________");

        $urls = Url::all();
        var_dump("_______________________show_all_url_in_table_again______________________");
        foreach ($urls as $url) {
            var_dump($url['id']);
            var_dump($url['name']);
        }

        flash('Url was added successfully')->success();
        return redirect()
            ->route('urls.show', $url->id);
    }

    public function show($id)
    {
        $url = Url::findOrFail($id);
        $url_checks = UrlCheck::where('url_id', $id)->get();
        return view('urls.show', compact('url', 'url_checks'));
    }
}
