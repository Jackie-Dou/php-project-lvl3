<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Carbon\Carbon;
use DiDom\Document;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UrlCheckController extends Controller
{
    private function analysePage(string $htmlBody): array
    {
        $document = new Document($htmlBody);
        $seoInfo = [];
        $seoInfo['h1'] = optional($document->first('h1'))->text();
        $seoInfo['description'] = optional($document->first('meta[name="description"]'))
            ->getAttribute('content');
        $seoInfo['keywords'] = optional($document->first('meta[name="keywords"]'))
            ->getAttribute('content');
        return $seoInfo;
    }

    public function store(int $id): \Illuminate\Http\RedirectResponse
    {
        $url = Url::findOrFail($id);
        abort_unless(($url !== null), 404);

        try {
            $httpResponse = Http::get($url->name);
            $seoInfo = $this->analysePage($httpResponse->body());
            $urlChecks = [
                'url_id' => $id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'h1' => $seoInfo['h1'],
                'keywords' => $seoInfo['keywords'],
                'description' => $seoInfo['description'],
                'status_code' => $httpResponse->status(),
            ];
            DB::table('url_checks')->insert($urlChecks);
            flash('Url was checked successfully')->success();
        } catch (RequestException $e) {
            flash("Request failed")->error();
        } catch (ConnectionException $e) {
            flash("Connection error")->error();
        }

        return redirect()
            ->route('urls.show', $id);
    }
}
