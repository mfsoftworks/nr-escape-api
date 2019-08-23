<?php

namespace App\Listeners;

use App\User;
use App\Post;
use App\Events\NewPostRepost;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use FCMGroup;

class PushRepostNotification
{
    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'push';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewPostRepost  $event
     * @return void
     */
    public function handle(NewPostRepost $event)
    {
        // Get Post Author FCM Token
        $fcm_to = Post::where('id', $event->post->repost_of)
            ->author()->value('fcm_token');

        // Get username that commented
        $username = User::where('id', $event->post->author)
            ->first()
            ->value('username');

        // Create Notification
        $notification = (new PayloadNotificationBuilder())
            ->setTitle('New Repost')
            ->setBody("{$username} reposted your post")
            ->build();

        // Send Notification
        $response = FCM::sendTo($fcm_to, null, $notification, null);
    }
}
