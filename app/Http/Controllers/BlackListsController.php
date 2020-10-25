<?php

namespace App\Http\Controllers;
use App\BlackList;
use Illuminate\Http\Request;

class BlackListsController extends Controller
{
    public function destroy($id)
    {
        $user = BlackList::where('user_id',$id);

        if (\Auth::id() === 1) {
            $user->delete();
        }

        // 前のURLへリダイレクトさせる
        return back();
    }
    public function edit($id)
    {
        if (\Auth::id() === 1) {
        $user= new BlackList;
        $user->user_id=$id;
        $user->save();
        }
        return back();
    }
}
