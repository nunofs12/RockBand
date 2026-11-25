<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Band;
use Illuminate\Http\Request;

class AlbumAPIController extends Controller
{
    public function index()
    {
        return Album::paginate();
    }

    public function show(Album $album)
    {
        return $album;
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'band_id' => 'required|exists:bands,id',
            'album_name' => 'required|string|max:150',
            'release_date' => 'required|date',
            'record_lable' => 'nullable|string|max:150',
        ]);
        $band = Band::findOrFail($data['band_id']);
        $album = $band->albums()->create($data);
        $band->update(['number_of_albuns' => $band->albums()->count()]);
        return response()->json($album, 201);
    }

    public function update(Request $request, Album $album)
    {
        $data = $request->validate([
            'album_name' => 'required|string|max:150',
            'release_date' => 'required|date',
            'record_lable' => 'nullable|string|max:150',
        ]);
        $album->update($data);
        return $album;
    }

    public function destroy(Album $album)
    {
        return app(AlbumController::class)->destroy($album);
    }
}
