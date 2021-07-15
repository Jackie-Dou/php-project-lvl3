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
        var_dump("_______________________!!!______________________");
        var_dump($request->input('name'));

//        $str = getenv("DB_CONNECTION");
//        if ($str !== false) {
//            Log::info($str);
//        } else {
//            Log::info("error!");
//        }

        $urls = Url::all();
        var_dump("_______________________!!!______________________");
        var_dump($urls);

        try {
            $data = $this->validate(
                $request,
                ['name' => 'required|max:255|url']
            );
        } catch (ValidationException $e) {
            flash($e->getMessage())->error();
            return redirect()
                ->route('home');
        }
        try {
            $data = $this->validate(
                $request,
                ['name' => 'unique:urls']
            );
        } catch (ValidationException $e) {
            flash('This url already exists')->warning();
            return redirect()
                ->route('home');
        }

        $url = new Url();
        $insertData = array_merge($data, ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        $url->fill($insertData);
        $url->save();

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
