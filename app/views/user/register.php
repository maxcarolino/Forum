<h1 class="text-center"> Sign Up </h1>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="form-group">
            <form class="well" method="post" action="<?php char_to_html(url('')) ?>">
                <label> Username: </label>
                <input type="text" class="form-control" name="username"
                    placeholder="username" required>
                <label> Password: </label>
                <input type="password" class="form-control" name="password"
                    placeholder="password" required>
                <label> Re-type Password: </label>
                <input type="password" class="form-control" name="retype_password"
                    placeholder="retype password" required>
                <label> Email: </label>
                <input type="email" class="form-control" name="email"
                    placeholder="email" required>
                </br>
                <input type="hidden" name="page_next" value="register_end">
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-ok"></span>
                    Sign Up
                </button>
                </br></br>
                <a href="<?php char_to_html(url('user/log_in')) ?>">
                    Already have an account? Click here!
                </a>
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

            <!--check if password match-->
            <?php if(!empty($user->validation_errors['retype_password']['compare'])): ?>
                <div><em> Password</em> does not match!</div>
            <?php endif ?>

            <!--username isValid-->
            <?php if(!empty($user->validation_errors['username']['valid'])): ?>
                <div>
                    <em>Username</em> should only contain alphanumeric
                    characters and underscore only.
                </div>
            <?php endif ?>

            <!--password isValid-->
            <?php if(!empty($user->validation_errors['password']['valid'])): ?>
                <div>
                    <em>Password</em> should only contain alphanumeric
                    characters and underscore only.
                </div>
            <?php endif ?>

            <!--username field empty-->
            <?php if(!empty($user->validation_errors['username']['length'])): ?>
                <div><em> Username </em> must be between
                    <?php char_to_html($user->validation['username']['length'][1])
                        ?> to
                    <?php char_to_html($user->validation['username']['length'][2])
                        ?> characters only.
                </div>
            <?php endif ?>

            <!--password field empty-->
            <?php if(!empty($user->validation_errors['password']['length'])): ?>
                <div><em> Password </em> must be between
                    <?php char_to_html($user->validation['password']['length'][1])
                        ?> to
                    <?php char_to_html($user->validation['password']['length'][2])
                        ?> characters only.
                </div>
            <?php endif ?>

            <!--email field empty-->
            <?php if(!empty($user->validation_errors['email']['length'])): ?>
                <div><em> Email </em> must be between
                    <?php char_to_html($user->validation['email']['length'][1])
                        ?> to
                    <?php char_to_html($user->validation['email']['length'][2])
                        ?> characters only.
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<!--check if username exists-->
<?php elseif($user->username_exists($user->username)): ?>
<div class="row">
    <div class="col-md-3 col-md-offset-4">
        <div class="alert alert-warning" role="alert" width="50%">
            <h4><span class="glyphicon glyphicon-exclamation-sign"></span>
                Username is already taken!
            </h4>
        </div>
    </div>
</div>

<!--chech if email exists-->
<?php elseif($user->email_exists($user->email)): ?>
<div class="row">
    <div class="col-md-3 col-md-offset-4">
        <div class="alert alert-warning" role="alert" width="50%">
            <h4><span class="glyphicon glyphicon-exclamation-sign"></span>
                Email is already taken!
            </h4>
        </div>
    </div>
</div>
<?php endif ?>