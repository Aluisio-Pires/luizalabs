<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends APIController
{
    /**
     * Cria um novo Usuário.
     *
     * @Request({
     *      tags: Autenticação
     * })
     */
    public function register(Request $request): JsonResponse
    {
        $user = (new CreateNewUser)->create($request->all());

        return $this->response(['user' => $user], Response::HTTP_CREATED);
    }

    /**
     * Autentica um Usuário.
     *
     * @Request({
     *       tags: Autenticação
     *  })
     */
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return $this->error(
                [
                    'email' => [
                        'As credenciais fornecidas estão incorretas.',
                    ],
                ],
                'Credenciais inválidas.'
            );
        }

        $token = $user->createToken('apiToken')->plainTextToken;

        return $this->response([
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
    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->currentAccessToken();

        $token->delete();

        return $this->response(['message' => 'Logout efetuado com sucesso.']);
    }

    /**
     * Exibe os dados do Usuário autenticado.
     *
     * @Request({
     *       tags: Autenticação
     *  })
     */
    public function user(Request $request): JsonResponse
    {
        return $this->response(['user' => $request->user()]);
    }
}
