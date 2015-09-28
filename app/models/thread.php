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

    public static function getOwn($id, $user_id) //gets the owned threads
    {
        $db = DB::conn();

        $row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));

        if (!$row) {
            throw new RecordNotFoundException('No record found!');
        }
        $row['is_owner'] = self::isOwner($id, $user_id);
        return new self($row);
    }

    public static function get($id)
    {
        $db = DB::conn();

        $row = $db->row('SELECT * FROM thread WHERE id = ?', array($id));

        if (!$row) {
            throw new RecordNotFoundException('No record found!');
        }
        return new self($row);
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

    public function edit()
    {
        if (!$this->validate()) {
            throw new ValidationException('Invalid Thread');
        }

        $db = DB::conn();
        
        $params = array(
            'title'    => $this->title,
            'category' => $this->category
        );
        $db->update('thread', $params, array('id' => $this->id));
    }

    public static function isOwner($thread_id, $user_id)
    {
        $db = DB::conn();

        $row = $db->row('SELECT * FROM thread WHERE user_id = ? AND id = ?',
        array($user_id, $thread_id));

        return (bool) $row;
    }

    public function delete()
    {
        try {
            $db = DB::conn();
            $db->begin();

            Comment::deleteByThreadId($this->id);
            Bookmarks::deleteAllByThreadId($this->id);

            $db->query('DELETE FROM thread WHERE id = ?', array($this->id));
            $db->commit();
    
        } catch (Exception $e) {
            $db->rollback();
        }        
    }
    public static function getTrendingThreads()
    {
        $threads = array();
        $db = DB::conn();

        $trending_threads_id = Comment::sortMostComments();

        foreach ($trending_threads_id as $row) {
            $thread = $db->row('SELECT * FROM thread WHERE id = ?', array($row['thread_id']));
            $thread['count'] = $row['COUNT(*)'];
            $thread['date_created'] = date("F j, Y, g:i a", strtotime($thread['date']));
            $threads[] = new self ($thread);
        }
        return $threads;
    }

    public static function sortByCategory($offset, $limit, $user_id)
    {
       $threads = array();
       $db = DB::conn();
       $query = sprintf('SELECT * FROM thread ORDER BY CAST(category AS CHAR), title LIMIT %d, %d', $offset, $limit);
       $rows = $db->rows($query);

        foreach ($rows as $row) {
            $row['date_created'] = date("F j, Y, g:i a", strtotime($row['date']));
            $row['is_owner'] = self::isOwner($row['id'], $user_id);
            $row['username'] = User::getUsername($row['user_id']);
            $row['profile_pic'] = User::getProfilePic($row['user_id']);
            $row['is_bookmark'] = Bookmarks::isBookmark($user_id, $row['id']);
            $threads[] = new self($row);
        }
        return $threads;
    }

    public static function getByUser($user_id) //add pagination
    {
        $threads = array();
        $db = DB::conn();

        $rows = $db->rows('SELECT * FROM thread WHERE user_id = ?',
        array($user_id));

        foreach ($rows as $row) {
            $threads[] = new self($row);
        }

        return $threads;
    }
}