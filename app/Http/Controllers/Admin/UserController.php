<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Config;
use App\Http\Controllers\Controller;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Project;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(config('variables.paginate'));
        $data = [
            'users' => $users
        ];
        return view('admin.user.index', $data);
    }

    public function create()
    {
        $departments = Department::all();
        $data = [
            'departments' => $departments
        ];
        return view('admin.user.create', $data);
    }

    public function store(UserRequest $request)
    {
        $input = $request->except('avatar');
        if ($request->hasFile('avatar')) {
            $input['avatar'] = $request->file('avatar')->store('images', ['disk' => 'public']);
        }
        $input['password'] = \Hash::make($request->password);
        User::create($input);
        return redirect()->route('users.index')->with('message', __('messages.create_message'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $url = $user->getUrlAttribute($user->avatar);
        $data = [
            'user' => $user,
            'url' => $url
        ];
        return view('admin.user.show', $data);
    }

    public function edit($id)
    {
        $departments = Department::all();
        $user = User::findOrFail($id);
        $url = $user->getUrlAttribute($user->avatar);
        $data = [
            'user' => $user,
            'departments' => $departments,
            'url' => $url
        ];
        return view('admin.user.update', $data);
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $input = $request->except('avatar');
        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete('/' . $user->avatar);
            $input['avatar'] = $request->file('avatar')->store('images', ['disk' => 'public']);
            $input['password'] = \Hash::make($request->get('password'));
            $user->update($input);
        }
        else
        {
            $input['password'] = \Hash::make($request->get('password'));
            $user->update($input);
        }
        return redirect()->route('users.index')->with('message', __('messages.update_message'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->projects()->detach();
        $tasks = $user->tasks;
        foreach ($tasks as $task)
        {
            $task->update([
                'user_id' => null,
            ]);
        }
        $user->delete();
        return redirect()->route('users.index')->with('message', __('messages.delete_message'));
    }

    public function search(Request $request)
    {
        $userName = $request->user_name;
        $users = User::where('name', 'like', '%' . $userName . '%')->orderByDesc('id')->paginate(config('variables.paginate'));
        $data = [
            'users' => $users,
        ];
        return view('admin.user.index', $data);
    }
}
