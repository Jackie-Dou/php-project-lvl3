<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UrlCheckController extends Controller
{
    public function store($id): \Illuminate\Http\RedirectResponse
    {
        $url = Url::findOrFail($id);
        abort_unless($url, 404);

        try {
            $httpResponse = Http::get($url->name);
            $urlChecks = [
                'url_id' => $id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'status_code' => $httpResponse->status(),
            ];
            DB::table('url_checks')->insert($urlChecks);
            flash('Url was checked successfully')->success();
        } catch (RequestException $e) {
            flash("Request failed. Message: {$e->getMessage()}")->error();
        } catch (ConnectionException $e) {
            flash("Connection error. Message: {$e->getMessage()}")->error();
        }

        return redirect()
            ->route('urls.show', $id);
    }
}
