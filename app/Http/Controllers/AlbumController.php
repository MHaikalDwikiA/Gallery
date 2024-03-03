<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $albums = auth()->user()->albums;
        return view('page.album.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page.album.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ], [
            'title.required' => 'Judul harus diisi!',
            'description.required' => 'Deskripsi harus diisi!',
        ]);

        Album::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description
        ]);

        return redirect()->route('album.index')->withSuccess('Album berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $album = Album::find($id);
        abort_if(!$album, 400, 'Album tidak ditemukan!');

        return view('page.album.edit', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $album = Album::find($id);
        abort_if(!$album, 400, 'Album tidak ditemukan!');

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ], [
            'title.required' => 'Judul harus diisi!',
            'description.required' => 'Deskripsi harus diisi!',
        ]);

        $album->title = $request->title;
        $album->description = $request->description;
        $album->save();

        return redirect()->route('album.index')->withSuccess('Album berhasil diedit!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $album = Album::find($id);
        abort_if(!$album, 400, 'Album tidak ditemukan!');

        $photo = Photo::where('album_id', $album->id)->exists();
        if($photo){
            return back()->withError('Album tidak bisa dibisa dihapus karena memilki foto!');
        }

        $album->delete();

        return redirect()->route('album.index')->withSuccess('Album berhasil dihapus!');
    }
}
