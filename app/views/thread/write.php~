<h2 class="text-center"><?php eh($thread->title) ?> </h2>
<div class="row">
<div class="col-md-4 col-md-offset-4">
<div class="form-group">
<form class="well" method="post" action="<?php eh(url('thread/write')) ?>">
   <label> Comment: </label>
   <textarea name="body" class="form-control"><?php eh(Param::get('body')) ?></textarea>
   </br>
   <input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
   <input type="hidden" name="page_next" value="write_end">
   <button type="submit" class="btn btn-primary"> Submit </button>
   </br></br>
   <a href="<?php eh(url('thread/view', array('thread_id' => $thread->id))) ?>">
      &larr; Back to thread. 
   </a>
</form>
</div>
</div>
</div>

<?php if($comment->hasError()): ?>
<div class="row">
<div class="col-md-4 col-md-offset-4">
<div class="alert alert-warning" role="alert" width="50%">
   <h4>Validation Error!</h4>
   <?php if(!empty($comment->validation_errors['body']['length'])): ?>
      <div><em> Comment </em> must be between
      <?php eh($comment->validation['body']['length'][1]) ?> and
      <?php eh($comment->validation['body']['length'][2]) ?> characters in length
      </div>
   <?php endif ?>
</div>
</div>
</div>
<?php endif?>

