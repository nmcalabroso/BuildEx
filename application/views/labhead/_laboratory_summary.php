<?php if(isset($laboratory)): ?>
  <h1><?php echo $laboratory->name; ?></h1>
  <p><?php echo $laboratory->description; ?></p>
  <p>Members: <?php echo $laboratory->members_count; ?></p>
<?php else: ?>
  <p>You have no laboratory yet. <?php echo anchor(site_url('explore'), 'Explore!'); ?></p>
<?php endif; ?>
