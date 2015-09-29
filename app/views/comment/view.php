<div class="row">
    <div class="col-md-5 col-md-offset-3">
        <h1> <?php char_to_html($thread->title) ?>
            <span class="badge"><?php char_to_html($total) ?></span>
        </h1>
        <?php if ($thread->is_owner): ?>
            <h5>
                <a href="<?php char_to_html(url('thread/edit_thread',
                    array('thread_id' => $thread->id))) ?>">
                    <span class="glyphicon glyphicon-edit"></span>
                    Edit Thread </a>&nbsp;
                <a href="<?php char_to_html(url('thread/delete_thread',
                    array('thread_id' => $thread->id))) ?>">
                    <span class="glyphicon glyphicon-trash"></span>
                    Delete Thread </a>
            </h5>
        <?php endif ?>
    </div>
</div>
<?php if (empty($comments)): ?>
    <h4> No comments yet for this thread </h4>
<?php else: ?>
    <div class="row">
        <div class="col-md-5 col-md-offset-3">
            <ul class="list-group">
                <?php foreach ($comments as $k => $v): ?>
                    <li class="list-group-item"><img src="../<?php char_to_html($v->profile_pic) ?>" height="45" width="45" class="img-circle">
                        <?php if($v->is_owner): ?>
                            <a href="<?php char_to_html(url('user/profile')) ?>">
                                <?php echo char_to_html($v->username) ?>
                            </a>
                        <?php else: ?>
                            <a href="<?php char_to_html(url('user/other_user_profile',
                                array('user_id' => $v->user_id))) ?>">
                                <?php echo char_to_html($v->username) ?>
                            </a>
                        <?php endif ?>
                        <h6> Created: <?php char_to_html($v->date) ?></h6>
                        <h6> Modified: <?php char_to_html($v->date_modified) ?></h6>
                        <h5>Likes: <?php char_to_html($v->likes) ?></h5>
                        <br>
                        <h4><?php echo readable_text($v->body) ?></h3>
                        <?php if (!empty($v->filepath)): ?>
                            <img src="../<?php char_to_html($v->filepath) ?>" height="200" width="200" class="img-thumbnail">
                        <?php endif ?>
                        <br><br>
                        <?php if($v->is_like): ?>
                            <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
                            <a href="<?php char_to_html(url('likes/unlike',
                                array('thread_id' => $v->thread_id, 'comment_id' => $v->id)))?>">Unlike</a>
                        <?php else: ?>
                            <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                            <a href="<?php char_to_html(url('likes/set_like',
                                array('thread_id' => $v->thread_id, 'comment_id' => $v->id)))?>">Like</a>
                        <?php endif ?>
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
            <hr>
            <div class="form-group">
                <form class="well" method="post" action="<?php
                    char_to_html(url('comment/write')) ?>" enctype="multipart/form-data">
                    <label> Comment </label>
                    <textarea name="body" class="form-control"
                        placeholder="Your comment goes here." required></textarea>
                    <br/>
                    <input type="hidden" name="thread_id" value="<?php
                        char_to_html($thread->id) ?>">
                    <input type="file" name="pic">
                    <p class="help-block">Image Files Only. (max size: 5MB)</p>
                    <input type="hidden" name="page_next" value="write_end">
                    <button type="submit" class="btn btn-primary" name="btn-upload">
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
<?php endif ?>