<?php

namespace App\Http\Controllers;

use App\Artist;
use App\Http\Resources\ArtistResource;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index(Request $request)
    {
        return ArtistResource::collection(
            Artist::query()
            ->filter($request->only([
                Artist::FILTER_TYPE,
                Artist::FILTER_SEARCH_NAME,
                Artist::FILTER_ON_INDEX,
            ]))
            ->order($request->only('order'))
            ->paginate(10));
    }

    public function show($slug)
    {
        return new ArtistResource(Artist::query()->whereSlug($slug)->firstOrFail());
    }

}
