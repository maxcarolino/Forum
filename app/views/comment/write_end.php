<?php if (isset($_SESSION['username'])): ?>
    <h2><?php char_to_html($thread->title) ?></h2>

    <p class="alert alert-success">
        <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
        You successfully wrote this comment.
    </p>

    <a href="<?php char_to_html(url('comment/view',
        array('thread_id' => $thread->id))) ?>">
        <span class="glyphicon glyphicon-chevron-left"></span>
        Back to thread.
    </a>
<?php else: ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="alert alert-warning" role="warning" width="40%">
                <h2><span class="glyphicon glyphicon-warning-sign"
                    aria-hidden="true"></span>
                    Permission denied!
                </h2>
            </div>
        </div>
    </div>
<?php endif ?>