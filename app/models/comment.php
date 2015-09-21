<?php

class Comment extends AppModel
{
    CONST MIN_LENGTH = 1;
    CONST MAX_LENGTH = 255;

    public $validation  =  array (
        'body'          => array (
            'length'    => array ('validate_between',
                                  self::MIN_LENGTH, self::MAX_LENGTH,)
        )
    );

    public static function count($thread_id)
    {
        $db = DB::conn();
        return $db->value('SELECT COUNT(*) FROM comment WHERE thread_id = ?',
        array($thread_id));
    }

    public static function getAllByThreadId($offset, $limit, $thread_id)
    {
        $comments = array();
        $db = DB::conn();
        $query = sprintf('SELECT * FROM comment WHERE thread_id = ? ORDER BY
        date LIMIT %d, %d', $offset, $limit);
        $rows = $db->rows($query, array($thread_id));

        foreach ($rows as $row) {
            $row['username'] = User::getUsername($row['user_id']);
            $comments[] = new self($row);
        }

        return $comments;
    }
  
    public function write($thread_id)
    {
        if (!$this->validate()) {
            throw new ValidationException('Invalid comment');
        }
        $db = DB::conn();

        $params = array(
            'thread_id' => $thread_id,
            'user_id'   => $this->user_id,
            'body'      => $this->body,
        );

        $db->insert('comment', $params);
    }

    public static function sortMostComments()
    {
        $db = DB::conn();

        $thread_id = $db->rows('SELECT COUNT(*), thread_id FROM comment GROUP BY thread_id ORDER BY COUNT(*) DESC');

        return $thread_id;
    }

    
}