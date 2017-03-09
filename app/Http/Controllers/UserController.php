<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

/**
 * @Resource("Users", uri="/users")
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->cannot('list', User::class))
            abort(403);
        
        $limit = $request->input('limit', 30);
        return response()->json(User::paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', User::class))
            abort(403);

        $fields = $request->all();
        $fields['registration_ip'] = $request->ip();
        $new_user = User::create($fields);
        $new_user->save();
        return $new_user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = User::find($id);

        if ($user == null)
            abort(404);

        if ($request->user()->cannot('view', $user))
            abort(403);

        return $user;
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
        $user = User::findOrFail($id);

        if ($request->user()->cannot('update', $user))
            abort(403);

        $user->update($request->all());
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->user()->cannot('delete', $user))
            abort(403);

        $user->delete();
        return 'Deleted';
    }
}