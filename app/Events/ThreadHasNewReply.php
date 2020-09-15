<?php

    namespace App\Events;

    use Illuminate\Broadcasting\InteractsWithSockets;
    use Illuminate\Broadcasting\PrivateChannel;
    use Illuminate\Foundation\Events\Dispatchable;
    use Illuminate\Queue\SerializesModels;

    class ThreadHasNewReply
    {
        use SerializesModels;

        public $thread;
        public $reply;

        /**
         * Create a new event instance.
         *
         * @param \App\Thread $thread
         * @param \App\Reply $reply
         */
        public function __construct($thread, $reply)
        {
            $this->thread = $thread;
            $this->reply = $reply;
        }

    }
