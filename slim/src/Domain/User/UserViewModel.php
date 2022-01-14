<?php

namespace App\Domain\User;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="UserCreateViewModel"
 * )
 */
class UserCreateViewModel extends Model
{
    /**
     * @OA\Property(type="string", example="doe")
     */
    private $firstname;

    /**
     * @OA\Property(type="string", example="john")
     */
    private $lastname;

    /**
     * @OA\Property(type="string", example="johndoe@gmail.com")
     */
    private $email;


    /**
     * @OA\Property(type="string", example="password")
     */
    private $password;
}

/**
 * @OA\Schema(
 *     title="UserLoginViewModel"
 * )
 */
class UserLoginViewModel extends Model
{
    /**
     * @OA\Property(type="string", example="johndoe@gmail.com")
     */
    private $email;


    /**
     * @OA\Property(type="string", example="password")
     */
    private $password;
}
