<?php if ($field->subpages()->count() > 0): ?>
  <ul class="nav nav-list sidebar-list datalist-items">
    <?php foreach($field->subpages() as $subpage): ?>
      <?php echo new Snippet('pages/sidebar/subpage', array('subpage' => $subpage)) ?>
    <?php endforeach ?>
  </ul>
<?php else: ?>
  <div class="input input-with-items">
    <div class="item subpagelist-item-empty">
      <?php echo l::get('subpagelist.empty') ?>
    </div>
  </div>
<?php endif ?>
