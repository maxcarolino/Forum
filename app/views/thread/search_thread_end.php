<div class="row">
    <div class="col-md-5 col-md-offset-3">
        <?php if (empty($user_id)): ?>
            <h3> Username Not Found!</h3>
            <a href="<?php char_to_html(url('thread/index')) ?>">
                <span class="glyphicon glyphicon-chevron-left"></span>
                Back to thread list. 
            </a>
        <?php elseif (empty($threads)) : ?>
            <h3> No Threads created by this user!</h3>
            <a href="<?php char_to_html(url('thread/index')) ?>">
                <span class="glyphicon glyphicon-chevron-left"></span>
                Back to thread list. 
            </a>
        <?php else: ?>
            </br>
            <ul class="list-group">
                <?php foreach ($threads as $k => $v): ?>
                    <li class="list-group-item">
                        <h4><a href="<?php
                            char_to_html(url('comment/view',
                            array('thread_id' => $v->id))) ?>">
                            <?php char_to_html($v->title) ?>
                        </a></h4>
                        <h6> Tags: <em><?php char_to_html($v->category)?></em></h6>
                    </li>
                <?php endforeach ?>
            </ul>
            <a href="<?php char_to_html(url('thread/index')) ?>">
                <span class="glyphicon glyphicon-chevron-left"></span>
                Back to thread list. 
            </a>
        <?php endif ?>
    </div>
</div>