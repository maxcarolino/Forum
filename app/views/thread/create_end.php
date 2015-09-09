<?php if (isset($_SESSION['username'])): ?>
    <h2><?php char_to_html($thread->title) ?>
        <p class="alert alert-success">
            You successully created the thread.
        </p>
    </h2>

    <a href="<?php char_to_html(url('comment/view',
        array('thread_id' => $thread->id))) ?>">
        &larr; Go to thread
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
</div>
<?php endif ?>