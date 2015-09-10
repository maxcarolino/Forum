<?php if (isset($_SESSION['username'])): ?>
    <h2 class="text-center"><?php char_to_html($thread->title) ?> </h2>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="form-group">
                <form class="well" method="post" action="<?php
                    char_to_html(url('comment/write')) ?>">
                    <label> Comment: </label>
                    <textarea name="body" class="form-control"
                        placeholder="Your comment goes here." required></textarea>
                    </br>
                    <input type="hidden" name="thread_id" value="<?php
                        char_to_html($thread->id) ?>">
                    <input type="hidden" name="page_next" value="write_end">
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        Submit
                    </button>
                    </br></br>
                    <a href="<?php char_to_html(url('comment/view',
                        array('thread_id' => $thread->id))) ?>">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        Back to thread. 
                    </a>
                </form>
            </div>
        </div>
    </div>

    <?php if ($comment->hasError()): ?>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="alert alert-warning" role="alert" width="50%">
                    <h4>Validation Error!</h4>
                    <?php if (!empty($comment->validation_errors['body']['length'])): ?>
                        <div><em> Comment </em> must be between
                            <?php char_to_html($comment->validation['body']['length'][1])
                                ?> and
                            <?php char_to_html($comment->validation['body']['length'][2])
                                ?> characters in length
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    <?php endif?>
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