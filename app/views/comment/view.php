<?php if (isset($_SESSION['username'])): ?>
    <h1> <?php char_to_html($thread->title) ?>
        <span class="badge"><?php char_to_html($total) ?></span>
    </h1>
    <?php if (empty($comments)): ?>
        <h4> No comments yet for this thread </h4>
    <?php else: ?>
        <?php foreach ($comments as $k => $v): ?>
            <ul class="list-group">
                <li class="list-group-item"><?php char_to_html($k + 1) ?>:
                    <?php echo char_to_html($v->username) ?>
                    <?php char_to_html($v->created) ?> </br>
                    <?php echo readable_text($v->body) ?>
                </li>
            </ul>
        <?php endforeach ?>
        <!--pagination -->
        <nav>
            <ul class="pagination">
                <li>
                    <?php if ($pagination->current > 1): ?>
                        <a href='?thread_id=<?php echo $thread->id ?>&page=<?php
                            echo $pagination->prev ?>'>
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                    <?php else: ?>
                        <li class="disabled">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </li>
                    <?php endif ?>
                </li>
        
                <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <?php if ($i == $page): ?>
                        <li class="active"><a><?php echo $i ?></a></li>
                    <?php else: ?>
                        <li>
                            <a href='?thread_id=<?php echo $thread->id ?>&page=<?php 
                                echo $i ?>'><?php echo $i ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endfor; ?>
     
                <li>
                    <?php if (!$pagination->is_last_page): ?>
                        <a href='?thread_id=<?php echo $thread->id ?>&page=<?php
                            echo $pagination->next ?>'>
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    <?php else: ?>
                        <li class="disabled">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </li>
                    <?php endif ?>
                </li>
            </ul>
        </nav>
    <?php endif ?>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <form class="well" method="post" action="<?php
                        char_to_html(url('comment/write')) ?>">
                        <label> Comment </label>
                        <textarea name="body" class="form-control"
                            placeholder="Your comment goes here." required></textarea>
                        <br/>
                        <input type="hidden" name="thread_id" value="<?php
                            char_to_html($thread->id) ?>">
                        <input type="hidden" name="page_next" value="write_end">
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            Submit
                        </button>
                        <br/><br/>
                        <a href="http://10.3.140.112/thread/index">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                            Go to thread list
                        </a>
                    </form>
                </div>
            </div>
        </div>
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