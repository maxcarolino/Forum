<?php

class LikesController extends AppController
{
    
    public function set_like() {
        check_user_session();
        $thread_id = Param::get('thread_id');
        $user_id = $_SESSION['user_id'];

        Likes::setLike($user_id, Param::get('comment_id'));
        redirect_to(url(COMMENT_VIEW.$thread_id));
    }

    public function unlike() {
        check_user_session();
        $thread_id = Param::get('thread_id');
        $user_id = $_SESSION['user_id'];

        Likes::unlike($user_id, Param::get('comment_id'));
        redirect_to(url(COMMENT_VIEW.$thread_id));
    }
}