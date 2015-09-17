<?php

class Thread extends AppModel
{
    CONST MIN_LENGTH = 1;
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

    public function create(Comment $comment)
    {
        $this->validate();
        $comment->validate();

        if ($this->hasError() || $comment->hasError()) {
            throw new ValidationException('Invalid thread or comment.');
        }

        $db = DB::conn();

        $params = array(
            'user_id'  => $this->user_id,
            'title'    => $this->title,
            'category' => $this->category
        );

        $db->insert('thread', $params);

        $this->id = $db->lastInsertId();

        //write the first comment
        $comment->write($this->id);

    }
}