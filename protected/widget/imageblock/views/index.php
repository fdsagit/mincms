<ul class="hover-block">
<?php foreach($posts as $p){?>
  <li> 
    <a href="<?php echo $p['url'];?>"> 
      <img src="<?php echo $p['img'];?>" alt="">  
      <div class="hover-content b-lblue" style="top: <?php echo $top;?>px;" style='overflow:hidden;'>
        <h6><?php echo $p['title'];?></h6>
          <?php echo $p['body'];?> 
      </div>
    </a> 
  </li> 
<?php }?>
</ul>