<h2 class="text-center">Edit Comment:</h2>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="form-group">
            <form class="well" method="post" action="<?php
                char_to_html(url('')) ?>" enctype="multipart/form-data">
                <label> Comment: </label>
                <textarea name="body" class="form-control" required><?php char_to_html($comment->body) ?></textarea>
                </br>
                <input type="file" name="pic">
                <p class="help-block">Image Files Only. (max size: 5MB)</p>
                <input type="hidden" name="page_next" value="edit_comment_end">
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    Submit
                </button>
                </br>
            </form>
            <a href="<?php char_to_html(url('comment/view',
                array('thread_id' => $thread->id))) ?>">
                <span class="glyphicon glyphicon-chevron-left"></span>
                Cancel
            </a>
        </div>
    </div>
</div>

<?php if ($comment->hasError()): ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="alert alert-warning" role="alert" width="50%">
                <h4>
                    <span class="glyphicon glyphicon-exclamation-sign"></span>
                    Validation Error!
                </h4>
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