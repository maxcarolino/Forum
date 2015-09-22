<?php

class Bookmarks extends AppModel
{
    public static function setBookmarks($user_id, $thread_id)
    {
        $db = DB::conn();

        $params = array(
            'user_id'   => $user_id,
            'thread_id' => $thread_id
        );

        $db->insert('bookmark', $params);
    }

    public static function unsetBookmarks($user_id, $thread_id)
    {
        $db = DB::conn();

        $db->query('DELETE FROM bookmark WHERE user_id = ? AND thread_id = ?',
        array($user_id, $thread_id));
    }

    public static function isBookmark($user_id, $thread_id)
    {
        $db = DB::conn();

        $row = $db->row('SELECT * FROM bookmark WHERE user_id = ? AND thread_id = ?',
        array($user_id, $thread_id));

        return (bool) $row;
    }

    public static function getAllByUser($user_id)
    {
        $threads = array();
        $db = DB::conn();

        $rows = $db->rows('SELECT thread_id FROM bookmark WHERE user_id = ?',
        array($user_id));

        foreach ($rows as $row) {
            $threads[] = Thread::get($row['thread_id']);  //pass the thread_id value
        }
        return $threads;
    }
}