<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    /**
     * Отображение формы редактирования пользователя.
     *
     * @param  int  $id
     * @return Response|Factory|View
     */
    public function edit($id)
    {
        $user = User::with(['likes.poster', 'comments.poster'])->findOrFail($id);
        return view('UsersEdit', compact('user'));
    }

    /**
     * Обновление данных пользователя.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response|RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->back()->with('success', 'Пользователь успешно обновлен');
    }

    /**
     * Удаление комментария.
     *
     * @param  int  $id
     * @return Response|RedirectResponse
     */
    public function destroyComment($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Комментарий успешно удален');
    }
}