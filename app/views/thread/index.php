<h1>All threads</h1>
<ul class="list-group">
   <?php foreach ($threads as $v): ?>
      <li class="list-group-item"><a href="<?php eh(url('thread/view', array('thread_id' => $v->id))) ?>">
      <?php eh($v->title) ?></a>
      </li>
   <?php endforeach ?>
</ul>

</br>
<a class="btn btn-large btn-primary" href="<?php eh(url('thread/create')) ?>">
   <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
    Create Thread </a>

