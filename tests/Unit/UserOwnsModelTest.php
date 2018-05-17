<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Model;

class UserOwnsModelTest extends TestCase
{
    /** @test */
    public function a_user_owns_a_model()
    {
        $userA = new User();
        $userA->id = 1;

        $userB = new User();
        $userA->id = 2;

        $ownedByUserA = new OwnedModel(['user_id' => $userA->id]);
        $ownedByUserB = new OwnedModel(['user_id' => $userB->id]);

        $this->assertTrue($userA->owns($ownedByUserA));

        $this->assertTrue($userB->owns($ownedByUserB));

        $this->assertFalse($userA->owns($ownedByUserB));

        $this->assertFalse($userB->owns($ownedByUserA));
    }
}

class OwnedModel extends Model
{
    protected $guarded = [];
}
