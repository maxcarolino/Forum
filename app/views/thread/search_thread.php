<div class="row">
    <div class="col-md-5 col-md-offset-3">
        <h2> Search Threads</h2>
    </div>
</div>
<div class="row">
    <div class="col-md-5 col-md-offset-3">
        <div class="form-group">
            <form class="well" method="post" action="<?php
                char_to_html(url('')) ?>">
                <input type="text" class="form-control" name="username"
                    placeholder="username of owner" required></br>
                <input type="hidden" name="page_next" value="search_thread_end">
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