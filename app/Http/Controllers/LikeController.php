<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like($id)
    {
        $photo = Photo::find($id);
        $like = Like::where('user_id', Auth::user()->id)->where('photo_id', $photo->id)->first();

        if (!$like) {
            Like::create([
                'photo_id' => $photo->id,
                'user_id' => Auth::user()->id,
            ]);
        } else {
            $like->delete();
        }

        return redirect()->back();
    }
}
