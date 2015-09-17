<div class="row">
    <div class="col-md-4">
        <h1> Edit Profile </h1>
        <div class="form-group">
            <form class="well" method="post" action="<?php char_to_html(url('')) ?>">
                <label> Username: </label>
                <input type="text" class="form-control" name="username"
                    placeholder="username" required>
                <label> First Name: </label>
                <input type="text" class="form-control" name="firstname"
                    placeholder="firstname" required>
                <label> Last Name: </label>
                <input type="text" class="form-control" name="lastname"
                    placeholder="lastname" required>
                <label> Email: </label>
                <input type="email" class="form-control" name="email"
                    placeholder="email" required>
                <label> Department: </label>
                <input type="text" class="form-control" name="department"
                    placeholder="department" required>
                </br>
                <input type="hidden" name="page_next" value="profile_end">
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-ok"></span>
                    Save Changes
                </button>
            </form>
             <a href="<?php char_to_html(url('user/profile')) ?>">
                <span class="glyphicon glyphicon-chevron-left"></span>
                Cancel Changes
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <h1> Change Password </h1>
        <div class="form-group">
            <form class="well" method="post" action="<?php char_to_html(url('')) ?>">
                <label> New Password: </label>
                <input type="password" class="form-control" name="password"
                    placeholder="password" required>
                <label> Re-type Password: </label>
                <input type="password" class="form-control" name="retype_password"
                    placeholder="retype password" required>
                <input type="hidden" name="page_next" value="password_end">
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-ok"></span>
                    Save Password
                </button>
            </form>
        </div>
    </div>
</div>
<?php if($user->hasError()): ?>
<div class="row">
    <div class="col-md-3 col-md-offset-4">
        <div class="alert alert-warning" role="alert" width="50%">
            <h4><span class="glyphicon glyphicon-exclamation-sign"></span>
                Oops! Something went wrong.
            </h4>

            <!--check if password does not match-->
            <?php if (!empty($user->validation_errors['retype_password']['compare'])): ?>
                      <div><em> Password</em> does not match!</div>
            <?php endif ?>

            <!--username is not valid-->
            <?php if (!empty($user->validation_errors['username']['valid'])): ?>
                      <div>
                          <em>Username</em> should only contain alphanumeric
                          characters and underscore only.
                      </div>
            <?php endif ?>

            <!--password is not valid-->
            <?php if (!empty($user->validation_errors['password']['valid'])): ?>
                      <div>
                          <em>Password</em> should only contain at least one digit from 0-9,
                           one lowercase character,
                           one uppercase character,
                           one special symbol (@#$%).
                      </div>
            <?php endif ?>

            <!--email is not valid-->
            <?php if (!empty($user->validation_errors['email']['valid'])): ?>
                      <div>
                          <em>Email</em> is invalid! Please provide another email.
                      </div>
            <?php endif ?>
            
            <!--username field is empty-->
            <?php if (!empty($user->validation_errors['username']['length'])): ?>
                      <div><em> Username </em> must be between
                          <?php char_to_html($user->validation['username']['length'][1])
                              ?> to
                          <?php char_to_html($user->validation['username']['length'][2])
                              ?> characters only.
                      </div>
            <?php endif ?>

            <!--password field is empty-->
            <?php if (!empty($user->validation_errors['password']['length'])): ?>
                      <div><em> Password </em> must be between
                          <?php char_to_html($user->validation['password']['length'][1])
                              ?> to
                          <?php char_to_html($user->validation['password']['length'][2])
                              ?> characters only.
                      </div>
            <?php endif ?>

            <!--email field is empty-->
            <?php if (!empty($user->validation_errors['email']['length'])): ?>
                      <div><em> Email </em> must be between
                          <?php char_to_html($user->validation['email']['length'][1])
                              ?> to
                          <?php char_to_html($user->validation['email']['length'][2])
                              ?> characters only.
                      </div>
            <?php endif ?>

            <!--firstname field is empty-->
            <?php if (!empty($user->validation_errors['firstname']['length'])): ?>
                      <div><em> First Name </em> must be between
                          <?php char_to_html($user->validation['firstname']['length'][1])
                              ?> to
                          <?php char_to_html($user->validation['firstname']['length'][2])
                              ?> characters only.
                      </div>
            <?php endif ?>

            <!--lastname field is empty-->
            <?php if (!empty($user->validation_errors['lastname']['length'])): ?>
                      <div><em> Last Name </em> must be between
                          <?php char_to_html($user->validation['lastname']['length'][1])
                              ?> to
                          <?php char_to_html($user->validation['lastname']['length'][2])
                              ?> characters only.
                      </div>
            <?php endif ?>

            <!--deparment field is empty-->
            <?php if (!empty($user->validation_errors['department']['length'])): ?>
                      <div><em> Department </em> must be between
                          <?php char_to_html($user->validation['department']['length'][1])
                              ?> to
                          <?php char_to_html($user->validation['department']['length'][2])
                              ?> characters only.
                      </div>
            <?php endif ?>

            <!--email or username already taken-->
            <?php if (!empty($user->validation_errors['email']['unique'])): ?>
                      <div><em>Username or Email</em> is already taken!</div>
            <?php endif ?> 
        </div>
    </div>
</div>
<?php endif ?>