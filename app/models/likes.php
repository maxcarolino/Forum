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

    public static function unLike($user_id, $comment_id)
    {
        $db = DB::conn();

        $db->query('DELETE FROM likes WHERE user_id = ? AND comment_id = ?',
        array($user_id, $comment_id));
    }

    public static function countLike($comment_id)
    {
        $db = DB::conn();

        $row = $db->value('SELECT COUNT(*) FROM likes WHERE comment_id = ? GROUP BY comment_id',
        array($comment_id));

        return (int) $row;
    }

    public static function mostLikes()
    {
        $db = DB::conn();

        $rows = $db->rows('SELECT COUNT(*), * FROM likes GROUP BY comment_id ORDER BY COUNT(*) DESC');

        return $rows;
    }
}