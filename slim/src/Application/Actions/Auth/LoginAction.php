<?php
declare(strict_types=1);

namespace App\Application\Actions\Auth;

use Error;
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends AuthAction
{
    /**
     * @OA\Post (
     *   tags={"Auth"},
     *   path="/auth/login",
     *   operationId="login",
     *   @OA\RequestBody (
     *     name="body",
     *     in="body",
     *     description="User email used to create account.",
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/UserLoginViewModel"),
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="login",
     *     @OA\JsonContent(ref="#/components/schemas/BearerToken")
     *   )
     * )
     */
    protected function action(): Response
    {
        $input = (array)$this->request->getParsedBody();
        $jwt = $this->login($input);
        $data = json_decode((string)json_encode($input), false);
        $password = hash('sha512', $data->password . $this->settings->get('SECRET_SALT'));
        $user = $this->loginUser($data->email, $password)[0];
        $message = [
            'Authorization' => 'Bearer ' . $jwt,
            'User' => $user,
        ];

        return $this->respondWithData($message);
    }

    private function login(array $input): string
    {
        $data = json_decode((string)json_encode($input), false);
        if (!isset($data->email)) {
            throw new Error('The field "email" is required.', 400);
        }
        if (!isset($data->password)) {
            throw new Error('The field "password" is required.', 400);
        }
        $password = hash('sha512', $data->password . $this->settings->get('SECRET_SALT'));
        $user = $this->loginUser($data->email, $password);
        $token = [
            'sub' => $user[0]['id'],
            'email' => $user[0]['email'],
            'name' => $user[0]['firstname'] . ' ' . $user[0]['lastname'],
            'iat' => time(),
            'exp' => time() + (7 * 24 * 60 * 60),
        ];
        return JWT::encode($token, "ef41rfr41gt41ht4h656thyth4y65unavion");
    }


    public function loginUser(string $email, string $password): array
    {
        $match = ['email' => $email, 'password' => $password];
        $user = $this->user->where($match)->get()->toArray();
        if (! $user) {
            throw new Error('Login failed: Email or password incorrect.', 400);
        }
        var_dump($user);
        return $user;
    }
}
