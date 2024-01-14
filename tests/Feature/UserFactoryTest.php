<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserFactoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the User Factory
     *
     * @return void
     */
    public function testUserFactory()
    {
        $user = User::factory()->make([
            'name' => 'Test User',
            'email' => 'test@user.com',
            'password' => Hash::make('12345'),
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@user.com', $user->email);
        $this->assertTrue(Hash::check('12345', $user->password));
    }
}
