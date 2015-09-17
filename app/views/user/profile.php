<div class="row">
    <div class="col-md-4">
        <h1> Your Profile </h1>
        <label> Username:   </label><h4><em><?php echo $user_account->username   ?></em></h4>
        <label> First Name: </label><h4><em><?php echo $user_account->firstname  ?></em></h4>
        <label> Last Name:  </label><h4><em><?php echo $user_account->lastname   ?></em></h4>
        <label> Department: </label><h4><em><?php echo $user_account->department ?></em></h4>
        <label> Email:      </label><h4><em><?php echo $user_account->email      ?></em></h4>

        <a class="btn btn-large btn-primary"
            href="<?php char_to_html(url('user/edit_profile')) ?>">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
            Edit Profile
        </a>
    </div>

    <div class="col-md-4">
        <h1> Your Bookmarks </h1>
        <ul>
            <li><a href="#"> Link Here </a></li>
            <li><a href="#"> Link Here </a></li>
            <li><a href="#"> Link Here </a></li>
        </ul>
    </div>
</div>