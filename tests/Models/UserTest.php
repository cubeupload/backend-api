<?php

use App\Models\Album;
use App\Models\AbuseReport;
use App\Models\Ban;
use App\Models\Image;
use App\Models\Message;
use App\Models\User;

use Laravel\Lumen\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testUserImageRelationship()
    {
        factory('App\Models\Image')->create();
        factory('App\Models\User')->create();

        $user = User::find(1);
        $image = Image::find(1);

        $user->images()->save($image);

        $this->assertEquals(1, $image->creator_id);
    }

    public function testUserAlbumRelationship()
    {
        factory('App\Models\User')->create();
        factory('App\Models\Album')->create();

        $user = User::find(1);
        $album = Album::find(1);

        $user->albums()->save($album);

        $this->assertEquals(1, $album->creator_id);
    }

    public function testUserBanRelationship()
    {
        factory('App\Models\User')->create();
        factory('App\Models\Ban')->create();

        $user = User::find(1);
        $ban = Ban::find(1);

        $user->bans()->save($ban);

        $this->assertEquals(1, $ban->recipient_id);
    }

    public function testUserMessageRelationship()
    {
        factory('App\Models\Message')->create();
        factory('App\Models\User')->create();

        $user = User::find(1);
        $message = Message::find(1);

        $user->messages()->save($message);
        
        $this->assertEquals(1, $message->creator_id);
        $this->assertEquals(1, count($user->messages));
    }

    public function testUserAbuseReportRelationship()
    {
        factory('App\Models\User')->create();
        factory('App\Models\User', 'moderator')->create();
        factory('App\Models\AbuseReport')->create();

        $user = User::find(1);
        $mod = User::find(2);
        $report = AbuseReport::find(1);

        $user->abuse_reports()->save($report);
        $mod->actioned_reports()->save($report);

        $this->assertEquals(1, $report->creator_id);
        $this->assertEquals(2, $report->actioner_id);
    }
}
