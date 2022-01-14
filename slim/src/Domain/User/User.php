<?php

namespace App\Domain\User;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="User"
 * )
 */
class User extends Model
{
    /**
     * @OA\Property(type="integer", format="int64", readOnly=true, example=1)
     */
    private $id;

    /**
     * @OA\Property(type="string", example="johndoe@gmail.com")
     */
    private $email;

    /**
     * @OA\Property(type="string", example="doe")
     */
    private $firstname;

    /**
     * @OA\Property(type="string", example="john")
     */
    private $lastname;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastname;
    }
}
