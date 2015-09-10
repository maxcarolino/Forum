<?php if (isset($_SESSION['username'])): ?>
    <h1 class="text-center">Create a thread</h1>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="form-group">
                <form class="well" method="post" action="<?php
                    char_to_html(url('')) ?>">
                    <label>Title:</label>
                    <input type="text" class="form-control" name="title"
                        placeholder="Your title goes here." required>
                    <label>Comment:</label>
                    <textarea name="body" class="form-control"
                        placeholder="Your comment goes here." required></textarea>
                    </br>
                    <input type="hidden" name="page_next" value="create_end">
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        Submit
                    </button>
                    </br></br>
                    <a href="<?php char_to_html(url('thread/index')) ?>">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        Back to thread list. 
                    </a>
                </form>
            </div>
        </div>
    </div>

    <?php if ($thread->hasError() || $comment->hasError()): ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="alert alert-warning" role="alert" width="50%">
                <h4>
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    Validation error!
                </h4>
                <?php if (!empty($thread->validation_errors['title']['length'])): ?>
                    <div><em>Title</em> must be between
                        <?php char_to_html($thread->validation['title']['length'][1])
                            ?> and
                        <?php char_to_html($thread->validation['title']['length'][2])
                            ?> characters in length.
                    </div>
                <?php endif ?>   

                <?php if (!empty($comment->validation_errors['body']['length'])): ?>
                    <div><em>Comment</em> must be between
                        <?php char_to_html($comment->validation['body']['length'][1])
                            ?>
                        <?php char_to_html($comment->validation['body']['length'][2])
                            ?> characters in length.
                    <div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <?php endif ?>
<?php else: ?>
    <!--redirect to denied page-->
    <?php redirect() ?>
</div>
<?php endif ?>