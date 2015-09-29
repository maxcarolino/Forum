<?php

class BookmarksController extends AppController
{
	CONST THREAD_INDEX = 'thread/index';
    
	public function set_bookmark() {
        check_user_session();
        $user_id = $_SESSION['user_id'];
        $thread_id = Param::get('thread_id');

        Bookmarks::add($user_id, $thread_id);
        redirect_to(url(self::THREAD_INDEX));
    }

    public function unset_bookmark() {
        check_user_session();
        $user_id = $_SESSION['user_id'];
        $thread_id = Param::get('thread_id');
        
        Bookmarks::remove($user_id, $thread_id);
        redirect_to(url(self::THREAD_INDEX));
    }
}