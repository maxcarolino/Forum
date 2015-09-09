<?php if (isset($_SESSION['username'])): ?>
<div class="row">
    <div class="col-md-8">
        <h1> All threads
            <span class="badge"><?php char_to_html($total) ?></span>
        </h1>
    </div>

    <div class="col-md-4">
        <a class="btn btn-warning" href="<?php char_to_html(url('user/log_out')) ?>">
            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
            Sign-Out
        </a>
    </div>
</div>

<div class="row">
    <ul class="list-group">
        <?php foreach ($threads as $v): ?>
            <li class="list-group-item">
                <a href="<?php
                    char_to_html(url('comment/view',
                    array('thread_id' => $v->id))) ?>">
                    <?php char_to_html($v->title) ?>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
    </br>
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
    </br></br>
    <a class="btn btn-large btn-primary" href="<?php
        char_to_html(url('thread/create')) ?>">
        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
        Create Thread
    </a>

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
</div>
<?php endif ?>