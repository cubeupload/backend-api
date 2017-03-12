<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', 30);

        // Request is asking for all user albums (mod/admin)
        if ($request->input('all'))
        {
            $this->authorize('listall', Album::class);
            return Album::paginate($limit);
        }
        // Normal request for authed user's albums.
        else
        {
            $this->authorize('list', Album::class);
            return $request->user()->albums()->paginate($limit);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $this->authorize('store', Album::class);

        $album = new Album($input);
        $album->save();
        return $album;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $album = Album::findOrFail($id);        
        $this->authorize($album);

        return $album;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);
        $this->authorize($album);

        $album->update($request->all());
        return $album;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        $this->authorize($album);

        $album->delete();
        return 'Deleted.';
    }
}
