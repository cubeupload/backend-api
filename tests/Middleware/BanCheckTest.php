<?php

use App\Models\Ban;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class BanCheckTest extends TestCase
{
    use DatabaseMigrations;
    use TestHelpersTrait;

    public function testBanCheckBansUnauthed()
    {
        $ban = factory(Ban::class)->create();
        $ban->banned_ip = '127.0.0.1';
        $ban->reason = 'Test Ban';
        $ban->enabled = true;
        $ban->save();

        $ban_ipv6 = factory(Ban::class)->create();
        $ban_ipv6->banned_ip = '::1';
        $ban_ipv6->reason = 'Test Ban';
        $ban_ipv6->enabled = true;
        $ban_ipv6->save();

        $this->get('/api/images');
        //var_dump($this->response);
        $this->seeStatusCode(403);

        $this->seeJson(['reason' => 'Test Ban']);
    }
}

// $user = factory(User::class)->create();