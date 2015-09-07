<h1 class="text-center"> Sign Up </h1>
<div class="row">
   <div class="col-md-4 col-md-offset-4">
      <div class="form-group">
         <form class="well" method="post" action="<?php eh(url('')) ?>">
            <label> Username: </label>
            <input type="text" class="form-control" name="username" value="<?php eh(Param::get('username')) ?>">
            <label> Password: </label>
            <input type="password" class="form-control" name="password" value="<?php eh(Param::get('password')) ?>">
            <label> Re-type Password: </label>
            <input type="password" class="form-control" name="retype_password" value="<?php eh(Param::get('retype_password')) ?>">
            <label> Email: </label>      
            <input type="email" class="form-control" name="email" value="<?php eh(Param::get('email')) ?>">
            </br>
            <input type="hidden" name="page_next" value="register_end">
            <button type="submit" class="btn btn-primary">
            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            Sign Up </button>
            </br></br>
            <a href="<?php eh(url('user/login')) ?>">Already have an account? Click here! </a> 
         </form>
      </div>
   </div>
</div>

<?php if($user->hasError()): ?>
<div class="row">
   <div class="col-md-3 col-md-offset-4">
      <div class="alert alert-warning" role="alert" width="50%">
         <h4><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Oops! Something went wrong.</h4>

         <!--check if password match-->
         <?php if(!empty($user->validation_errors['retype_password']['compare'])): ?>
         <div><em> Password</em> does not match!</div>
         <?php endif ?>

        <!--username isValid-->
        <?php if(!empty($user->validation_errors['username']['valid'])): ?>
        <div><em>Username</em> should only contain alphanumeric characters and underscore only.</div>
        <?php endif ?>

        <!--password isValid-->
        <?php if(!empty($user->validation_errors['password']['valid'])): ?>
        <div><em>Password</em> should only contain alphanumeric characters and underscore only.</div>
        <?php endif ?>

        <!--username field empty-->
        <?php if(!empty($user->validation_errors['username']['length'])): ?>
        <div><em> Username </em> must be between
           <?php eh($user->validation['username']['length'][1]) ?> to
           <?php eh($user->validation['username']['length'][2]) ?> characters only.
        </div>
        <?php endif ?>

        <!--password field empty-->
        <?php if(!empty($user->validation_errors['password']['length'])): ?>
        <div><em> Password </em> must be between
           <?php eh($user->validation['password']['length'][1]) ?> to
           <?php eh($user->validation['password']['length'][2]) ?> characters only.
        </div>
        <?php endif ?>

        <!--email field empty-->
        <?php if(!empty($user->validation_errors['email']['length'])): ?>
        <div><em> Email </em> must be between
           <?php eh($user->validation['email']['length'][1]) ?> to
           <?php eh($user->validation['email']['length'][2]) ?> characters only.
        </div>
       <?php endif ?>

      </div>
   </div>
</div>

<!--check if username exists-->
<?php elseif(User::username_exists($user->username)): ?>
<div class="row">
   <div class="col-md-3 col-md-offset-4">
      <div class="alert alert-warning" role="alert" width="50%">
         <h4><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Username is already taken!</h4>
      </div>
   </div>
</div>

<!--chech if email exists-->
<?php elseif(User::email_exists($user->email)): ?>
<div class="row">
   <div class="col-md-3 col-md-offset-4">
      <div class="alert alert-warning" role="alert" width="50%">
         <h4><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Email is already taken!</h4>
      </div>
   </div>
</div>
<?php endif ?>

