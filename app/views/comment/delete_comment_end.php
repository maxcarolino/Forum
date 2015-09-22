<h2>Deletion Successful!</h2>
    <p class="alert alert-success">
        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
        You successfully deleted this comment.
    </p>
    
    <a href="<?php char_to_html(url('comment/view',
        array('thread_id' => $thread->id))) ?>">
        <span class="glyphicon glyphicon-chevron-left"></span>
        Back to <?php echo $thread->title ?>
    </a>