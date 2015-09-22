<div class="row">
    <div class="col-md-4 col-md-offset-4">
    </br>
        <form class="well" method="post" action="<?php
            char_to_html(url('')) ?>">
            <h3>Do you want to delete this thread? </h3>
            <input type="hidden" name="page_next" value="delete_thread_end">
            <button type="submit" class="btn btn-danger">
                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                Submit
            </button>
        </form>
        <a href="<?php char_to_html(url('thread/index'))?>">
            <span class="glyphicon glyphicon-chevron-left"></span>
            Cancel
        </a>
    </div>
</div>