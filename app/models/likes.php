<?php

class Likes extends AppModel
{
    public static function setLike($user_id, $comment_id)
    {
        $db = DB::conn();

        $params = array(
            'comment_id' => $comment_id,
            'user_id'    => $user_id
        );

        $db->insert('likes', $params);
    }

    public static function unlike($user_id, $comment_id)
    {
        $db = DB::conn();

        $db->query('DELETE FROM likes WHERE user_id = ? AND comment_id = ?', array($user_id, $comment_id));
    }

    public static function isLike($user_id, $comment_id)
    {
        $db = DB::conn();
        $row = $db->row('SELECT * FROM likes WHERE user_id = ? AND comment_id = ?', array($user_id, $comment_id));

        return (bool) $row;
    }

    public static function count($comment_id)
    {
        $db = DB::conn();

        $row = $db->value('SELECT COUNT(*) FROM likes WHERE comment_id = ? GROUP BY comment_id', array($comment_id));

        return (int) $row;
    }

    public static function deleteByComment($comment_id)
    {
        $db = DB::conn();
        $db->query('DELETE FROM likes WHERE comment_id = ?', array($comment_id));
    }
}