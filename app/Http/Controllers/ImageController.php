<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', 30);

        // Request is asking for all user images (mod/admin)
        if ($request->input('all'))
        {
            $this->authorize('listall', Image::class);
            return Image::paginate($limit);
        }
        // Normal request for authed user's images.
        else
        {
            $this->authorize('list', Image::class);
            return $request->user()->images()->paginate($limit);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $image = Image::findOrFail($id);        
        $this->authorize($image);

        return $image;
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
        $image = Image::findOrFail($id);
        $this->authorize($image);

        $image->update($request->all());
        return $image;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $this->authorize($image);

        return ['deleted' => $image->delete()];
        //return 'Deleted.';
    }
}
