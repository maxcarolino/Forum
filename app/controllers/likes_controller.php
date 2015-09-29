<?php

class LikesController extends AppController
{
	CONST COMMENT_VIEW = '../comment/view?thread_id=';
    
	public function set_like()
    {
        check_user_session();
        $thread_id = Param::get('thread_id');
        $user_id = $_SESSION['user_id'];

        Likes::setLike($user_id, Param::get('comment_id'));
        header("location: ".self::COMMENT_VIEW.$thread_id);
    }

    public function unlike()
    {
        check_user_session();
        $thread_id = Param::get('thread_id');
        $user_id = $_SESSION['user_id'];

        Likes::unlike($user_id, Param::get('comment_id'));
        header("location: ".self::COMMENT_VIEW.$thread_id);
    }
}