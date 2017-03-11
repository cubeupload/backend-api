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
        $this->authorize('list', User::class);
        
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
        $this->authorize('store', User::class);

        $this->validate($request, [
            'name' => 'required',
            'password' => 'required',
            'email' => 'unique:users'
        ]);

        $fields = $request->all();
        $fields['registration_ip'] = $request->ip();
        $new_user = new User($fields);

        // Password isn't fillable so we set it here.
        $new_user->password = $fields['password'];

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
        $user = User::findOrFail($id);

        $this->authorize($user);

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

        $this->authorize($user);

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

        $this->authorize($user);

        $user->delete();
        return 'Deleted';
    }
}