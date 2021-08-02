<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show update image
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function perfil()
    {
        return view('users.add-image');
    }

    public function updateUser(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
        ]);

        $file = $request->file('image');
        $nameFile = (explode('.', $file->getClientOriginalName()))[0];
        $fileOriginal = time() . Str::slug($nameFile) . '.' . $file->getClientOriginalExtension();
        $fileEncrypted = encrypt($fileOriginal) . '.' . $file->getClientOriginalExtension();
        $pathImage = Auth::id().'/'.$fileEncrypted;
        $saveFile = Storage::putFileAs(
            '/public/' . Auth::user()->id . '/',
            $file,
            $fileEncrypted
        );

        if ($saveFile) {
            $user = Auth::user();
            $user->image = $pathImage;
            $user->save();
            return redirect()->route('perfil.user')->with(['save' => true, 'image' => $pathImage]);
        } else {
            return abort_unless(true, 500, 'Not save image');
        }
    }
}
