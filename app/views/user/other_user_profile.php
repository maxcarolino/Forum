<div class="row">
    <div class="col-md-4">
        <h1> <?php echo $user_account->username?>'s Profile </h1>
        <h2><?php echo $user_account->firstname?>
        <?php echo $user_account->lastname?></h2>
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
        <h1> <?php echo $user_account->username?>'s Bookmarks </h1>
        <ul>
            <?php foreach ($bookmark as $k => $v): ?>
                <li>
                    <h4><a href="<?php
                        char_to_html(url('comment/view',
                        array('thread_id' => $v->id))) ?>">
                        <?php char_to_html($v->title) ?>
                    </a></h4>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>