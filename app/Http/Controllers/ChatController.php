<?php

namespace App\Http\Controllers;

use App\Chat;
use App\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Chat $chat)
    {
        abort_unless($chat->users->contains(auth()->id()), 403, 'No autorizado');
        return view('chat.view_chat', [
            'chat' => $chat
        ]);
    }

    public function getMessages(Chat $chat)
    {
        $messages = $chat->messages()->with('user')->get();

        return response()->json([
            'messages' => $messages
        ]);
    }

    public function getUsers(Chat $chat): JsonResponse
    {
        $users = $chat->users;
        return response()->json([
            'users' => $users
        ]);
    }

    public function with(User $user)
    {
        // Primero recuperamos al usuario que realiza la solicitud
        $user_a = Auth::user();

        // Usuario con el que deseamos chatear
        $user_b = $user;

        // Vamos a recuperar la sala de chat del usuario a que tambien tenga al usuario b
        $chat = $user_a->chats()->whereHas('users', function ($q) use ($user_b) {

            // Aquí buscamos la relación con el usuario b
            $q->where('chat_user.user_id', $user_b->id);

        })->first();

        // Si la sala no existe debemos crearla
        if (!$chat) {

            // La sala no tiene ningún parámetro
            $chat = Chat::create([]);

            // Después adjuntamos a ambos usuarios
            $chat->users()->sync([$user_a->id, $user_b->id]);

        }

        // Redireccionamos al usuario a la ruta chat.show
        return redirect()->route('chat.show', $chat->id);
    }
}
