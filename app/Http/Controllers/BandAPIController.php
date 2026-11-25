<?php

namespace App\Http\Controllers;

use App\Models\Band;
use Illuminate\Http\Request;

class BandAPIController extends Controller
{
    public function index()
    {
        return Band::withCount('albums')->paginate();
    }

    public function show(Band $band)
    {
        return $band->load('albums');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name_of_band' => 'required|string|max:100|unique:bands,name_of_band']);
        $data['number_of_albuns'] = 0;
        return response()->json(Band::create($data), 201);
    }

    public function update(Request $request, Band $band)
    {
        $data = $request->validate(['name_of_band' => 'required|string|max:100|unique:bands,name_of_band,'.$band->id]);
        $band->update($data);
        return $band;
    }

    public function destroy(Band $band)
    {
        // Reutilizar a limpeza de imagens e álbuns do CRUD web.
        return app(BandController::class)->destroy($band);
    }
}
