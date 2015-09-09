<?php

class Thread extends AppModel
{
    CONST MIN_LENGTH = 5;
    CONST MAX_LENGTH = 30;

    public $validation  =  array (
        'title'         => array (
            'length'    => array ('validate_between',
                                  self::MIN_LENGTH, self::MAX_LENGTH,),
        ),
    );

    public static function get($id)
    {
        $db = DB::conn();

        $row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));

        if (!$row) {
            throw new RecordNotFoundException('No record found!');
        }

        return new self($row);
    }

    public static function getAll($offset, $limit)
    {
        $threads = array();
        $db = DB::conn();
        $query = sprintf('SELECT * FROM thread LIMIT %d, %d', $offset, $limit);
        $rows = $db->rows($query);

        foreach ($rows as $row) {
            $threads[] = new self($row);
        }

        return $threads;
    }
  
    public static function countAll()
    {
        $db = DB::conn();
        return $db->value('SELECT COUNT(*) FROM thread');
    }

    public function create(Comment $comment, $comment_user_id, $comment_body)
    {
        $this->validate();
        $comment->validate();

        if ($this->hasError() || $comment->hasError()) {
            throw new ValidationException('Invalid thread or comment.');
        }

        $db = DB::conn();
        $db->begin();

        $db->query('INSERT INTO thread SET title = ?, created = NOW()', 
        array(escapeString($this->title)));

        $this->id = $db->lastInsertId();

        //write the first comment
        $comment->write($comment, $this->id, $comment_user_id, $comment_body);

        $db->commit();
    }
}