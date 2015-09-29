<?php

class BookmarksController extends AppController
{
    
    public function set_bookmark() {
        check_user_session();
        $user_id = $_SESSION['user_id'];
        $thread_id = Param::get('thread_id');

        Bookmarks::add($user_id, $thread_id);
        redirect_to(url(THREAD_LIST));
    }

    public function unset_bookmark() {
        check_user_session();
        $user_id = $_SESSION['user_id'];
        $thread_id = Param::get('thread_id');
        
        Bookmarks::remove($user_id, $thread_id);
        redirect_to(url(THREAD_LIST));
    }
}