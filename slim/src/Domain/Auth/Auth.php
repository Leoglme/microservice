<?php
namespace App\Domain\Auth;

use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{

}

/**
 * @OA\Schema(
 *     title="BearerToken"
 * )
 */
class BearerToken extends Model
{
    /**
     * @OA\Property(type="string", example="Bearer token")
     */
    private $Authorization;
}
