<div class="row">
    <div class="col-md-4 col-md-offset-4">
    </br>
        <form class="well" method="post" action="<?php
            char_to_html(url('thread/index')) ?>">
            <h3>Do you want to delete this thread? </h3>
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