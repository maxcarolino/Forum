<h1><?php eh($thread->title) ?></h1>

<?php foreach ($comments as $k => $v): ?>
   <ul class="list-group">
      <li class="list-group-item"><?php eh($k + 1) ?>: <?php eh($v->username) ?> <?php eh($v->created) ?>
      </br><?php eh($v->body) ?> </li>
   </ul>
<?php endforeach ?>

<hr>
<div class="row">
<div class="col-md-4">
<div class="form-group">
<form class="well" method="post" action="<?php eh(url('thread/write')) ?>">
   <label> Your name </label>
   <input type="text" class="form-control" name="username" value="<?php eh(Param::get('username')) ?>">

   <label> Comment </label>
   <textarea name="body" class="form-control"><?php eh(Param::get('body')) ?></textarea>
   <br/>
   <input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
   <input type="hidden" name="page_next" value="write_end">
   <button type="submit" class="btn btn-primary">
   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
    Submit </button><!--Add Icon-->
   <br/><br/>
   <a href="http://10.3.140.112"> &larr;
    Go to thread list </a>
</form>
