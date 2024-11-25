<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Cria um novo Usuário.
     *
     * @Request({
     *      tags: Autenticação
     * })
     */
    public function register(Request $request)
    {
        $user = (new CreateNewUser)->create($request->all());

        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Autentica um Usuário.
     *
     * @Request({
     *       tags: Autenticação
     *  })
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $token = $user->createToken('apiToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Desautentica um Usuário.
     *
     * @Request({
     *       tags: Autenticação
     *  })
     */
    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }

        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Exibe os dados do Usuário autenticado.
     *
     * @Request({
     *       tags: Autenticação
     *  })
     */
    public function user(Request $request)
    {
        return $request->user();
    }
}
