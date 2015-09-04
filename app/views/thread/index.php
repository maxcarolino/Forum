<?php if(isset($_SESSION['user_id'])): ?>
<div class="row">
<div class="col-md-9">
   <h1>All threads</h1>
</div>
   <div class="col-md-3">
      <a class="btn btn-primary" href="<?php eh(url('user/login')) ?>">
      <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
      Sign-Out
      </a>
  </div>
</div>
<div class="row">
    <ul class="list-group">
      <?php foreach ($threads as $v): ?>
         <li class="list-group-item"><a href="<?php eh(url('thread/view', array('thread_id' => $v->id))) ?>">
         <?php eh($v->title) ?></a>
         </li>
        <?php endforeach ?>
    </ul>
    </br>
    <!--pagination-->
    <nav>
     <ul class="pagination pagination-lg">
       <li>
         <?php if($pagination->current > 1): ?>
           <a href='?page=<?php echo $pagination->prev ?>'>
             <span aria-hidden="true">&laquo;</span>
           </a>
         <?php else: ?>
           <li class="disabled"><span aria-hidden="true">&laquo;</li></span>
         <?php endif ?>
       </li>
    
        <?php for($i = 1; $i <= $pages; $i++): ?>
          <?php if($i == $page): ?>
            <li class="disabled"><a><?php echo $i ?></a></li>
         <?php else: ?>
            <li><a href='?page=<?php echo $i ?>'><?php echo $i ?></a></li>
          <?php endif; ?>
        <?php endfor; ?>
 
       <li>
         <?php if(!$pagination->is_last_page): ?>
           <a href='?page=<?php echo $pagination->next ?>'>
             <span aria-hidden="true">&raquo;</span>
           </a>
         <?php else: ?>
           <li class="disabled"><span aria-hidden="true">&raquo;</li></span>
         <?php endif ?>
       </li>
     </ul>
   </nav>
    <!---->
    </br></br>
    <a class="btn btn-large btn-primary" href="<?php eh(url('thread/create')) ?>">
    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
    Create Thread </a>

<?php else: ?>
   <h1 class="text-center"> Permission Denied! </h1>
<?php endif ?>
</div>
