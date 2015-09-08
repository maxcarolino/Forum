<h1 class="text-center"> Sign In </h1>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="form-group">
            <form class="well" method="post" action="<?php char_to_html(url('')) ?>">
                <label> Username: </label>
                <input type="text" class="form-control" name="username" value="<?php char_to_html(Param::get('username')) ?>" required>
                <label> Password: </label>
                <input type="password" class="form-control" name="password" value="<?php char_to_html(Param::get('password')) ?>" required>
                </br>
                <input type="hidden" name="page_next" value="log_in_end">
                <button type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
                    Sign In 
                </button>
                </br></br>
                <a href="<?php char_to_html(url('user/register')) ?>"> Or click here to Sign Up </a>
            </form>
        </div>
    </div>
</div>

<?php if(!$user->validated): ?>
<div class="row">
    <div class="col-md-3 col-md-offset-4">
        <div class="alert alert-danger" role="alert" width="40%">
            <h4><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Invalid username or password! </h4>
        </div>
    </div>
</div>
<?php endif ?>