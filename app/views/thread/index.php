<div class="row">
    <div class="col-md-5 col-md-offset-3">
        <h1> All Threads
            <span class="badge"><?php char_to_html($total) ?></span>
        </h1>
    </div>
    <div class="col-md-4">
        <h1> Trending Threads </h1>
    </div>
</div>
<div class="row">
    <div class="col-md-5 col-md-offset-3">
        <ul class="list-group">
            <?php foreach ($threads as $v): ?>
                <li class="list-group-item">
                    <a href="<?php
                        char_to_html(url('comment/view',
                        array('thread_id' => $v->id))) ?>">
                        <h4><?php char_to_html($v->title) ?></h4>
                    </a>
                    </br>
                    <h6> Tags: <em><?php char_to_html($v->category)?></em></h6>
                    <h6> Created by: <em><?php char_to_html($v->username)?></em></h6>
                    <h6> Date Created: <em><?php char_to_html($v->date_created)?></em></h6>
                    <?php if($v->is_bookmark): ?>
                        <h5><a href="<?php char_to_html(url('thread/unset_bookmark',
                                array('thread_id' => $v->id)))?>"> Remove from bookmark </a></h5>
                    <?php else: ?>
                        <h5><a href="<?php char_to_html(url('thread/set_bookmark',
                                array('thread_id' => $v->id)))?>"> Bookmark this Thread</a></h5>
                    <?php endif ?>
                    <?php if($v->is_owner): ?>
                       <h6><a href="<?php char_to_html(url('thread/edit_thread',
                            array('thread_id' => $v->id))) ?>"> Edit Thread </a></h6>
                        <h6><a href="<?php char_to_html(url('thread/delete_thread',
                            array('thread_id' => $v->id))) ?>"> Delete Thread </a></h6>
                    <?php endif ?>
                </li>
            <?php endforeach ?>
        </ul>
        </br>
    </div>
    <div class="col-md-4">
        <ul class="list-group">
           <?php foreach ($trending_threads as $v): ?>
               <li class="list-group-item">
                    <a href="<?php
                        char_to_html(url('comment/view',
                        array('thread_id' => $v->id))) ?>">
                        <h4><?php char_to_html($v->title) ?> 
                           <span class="badge"><?php char_to_html($v->count) ?></span>
                        </h4>
                   </a>
                    <h6> Tags: <em><?php char_to_html($v->category)?></em></h6>
                </li>
            <?php endforeach ?>
        </ul>
        </br>
    </div>
</div>
<div class="row">
    <div class="col-md-5 col-md-offset-3">
    <!--pagination-->
        <nav>
            <ul class="pagination pagination-lg">
                <li>
                    <?php if ($pagination->current > 1): ?>
                        <a href='?page=<?php echo $pagination->prev ?>'>
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
                            <a href='?page=<?php echo $i ?>'><?php echo $i ?></a>
                        </li>
                    <?php endif; ?>
                <?php endfor; ?>
     
                <li>
                    <?php if (!$pagination->is_last_page): ?>
                        <a href='?page=<?php echo $pagination->next ?>'>
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
        <!---->
        <a class="btn btn-large btn-primary" href="<?php
            char_to_html(url('thread/create')) ?>">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            Create Thread
        </a>
    </div>
</div>