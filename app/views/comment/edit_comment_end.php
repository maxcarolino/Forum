<h2><?php char_to_html($thread->title) ?></h2>
    <p class="alert alert-success">
        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
        You successfully updated this comment.
    </p>
    
    <a href="<?php char_to_html(url('comment/view',
        array('thread_id' => $thread->id))) ?>">
        <span class="glyphicon glyphicon-chevron-left"></span>
        Go to thread
    </a>