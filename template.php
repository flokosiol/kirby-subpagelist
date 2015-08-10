<?php if ($field->subpages()->count() > 0): ?>

  <?php echo $subpages; ?>

<?php else: ?>
  
  <div class="input input-with-items">
    <div class="item subpagelist-item-empty">
      <?php echo l::get('subpagelist.empty') ?>
    </div>
  </div>
  
<?php endif ?>

