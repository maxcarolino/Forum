<div class="row">
    <div class="col-md-4">
        <h3> Your Profile </h3>
    </div>
    <div class="col-md-4">
        <h3> Your Bookmarks </h3>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <h2><b><?php echo $user_account->firstname?>
        <?php echo $user_account->lastname?></b></h2>
        <h4>(<?php echo $user_account->username?>)</h4>
        <h5><em><?php echo $user_account->department?></em></h5>
        <h5><em><?php echo $user_account->email?></em></h5>

        </br>
        <a class="btn btn-large btn-primary"
            href="<?php char_to_html(url('user/edit_profile')) ?>">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            Edit Details
        </a>
    </div>

    <div class="col-md-4">
        <ul class="list-group">
            <?php foreach ($bookmark as $k => $v): ?>
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
    </div>
</div>