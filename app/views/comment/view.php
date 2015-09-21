<div class="row">
    <div class="col-md-5 col-md-offset-3">
        <h1> <?php char_to_html($thread->title) ?>
            <span class="badge"><?php char_to_html($total) ?></span>
        </h1>
    </div>
</div>
<?php if (empty($comments)): ?>
    <h4> No comments yet for this thread </h4>
<?php else: ?>
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <ul class="list-group">
                <?php foreach ($comments as $k => $v): ?>
                    <li class="list-group-item"><?php char_to_html($k + 1) ?>:
                        <b><?php echo char_to_html($v->username) ?></b>
                        <h6>Date Created: <?php char_to_html($v->date) ?></h6>
                        <h6>Date Modified: <?php char_to_html($v->date_modified) ?></h6>
                        <h4><?php echo readable_text($v->body) ?></h3>
                        <?php if($v->is_owner): ?>
                            <h6><a href="<?php char_to_html(url('comment/edit_comment',
                                array('thread_id' => $v->thread_id, 'comment_id' => $v->id))) ?>">
                                    Edit Comment </a></h6>
                            <h6><a href="<?php char_to_html(url('comment/delete_comment',
                                array('thread_id' => $v->thread_id, 'comment_id' => $v->id))) ?>">
                                    Delete Comment </a></h6>
                        <?php endif ?>
                    </li>
                    </br>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
    <!--pagination -->
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
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
                    </br></br>
                    <a href="http://10.3.140.112/thread/index">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        Go to thread list
                    </a>
                </form>
            </div>
        </div>
    </div>