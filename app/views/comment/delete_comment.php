<div class="row">
    <div class="col-md-4 col-md-offset-4">
    </br>
        <form class="well" method="post" action="<?php
            char_to_html(url('')) ?>">
            <h3>Do you want to delete this comment? </h3>
            <input type="hidden" name="page_next" value="delete_comment_end">
            <button type="submit" class="btn btn-danger">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                Submit
            </button>
        </form>
        <a href="<?php char_to_html(url('comment/view',
            array('thread_id' => $thread->id))) ?>">
            <span class="glyphicon glyphicon-chevron-left"></span>
            Back to <?php echo $thread->title ?>
        </a>
    </div>
</div>