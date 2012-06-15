<article id="my-account" class="canvas deals-index clearfix">
  <?php echo $this->element('default/account_navigation'); ?>
  <section id="my-deals">
  <h2 class="gradient brown">My Deals</h2>
    <div class="content">
      <?php if($deals): ?>
      <table cellpadding="0" cellspacing="0">
        <thead class="">
          <th class="first">Deal Name</th>
          <th class="status">Status</th>
          <th class="last" >Manage Deal</th>
        </thead>
        <?php
          $i = 0;
          foreach ($deals as $deal): ?>
            <tr class="<?php echo ($i%2) ? 'odd' : 'even'; ?>">

              <td><?php echo $deal['Deal']['product_name']; ?>&nbsp;</td>
              <td class="status"><?php echo $deal['Deal']['status']; ?>&nbsp;</td>

              <td class="actions">
                <?php echo $this->Html->link(__('Edit'), '/account/deals/edit/' . $deal['Deal']['id'], array('class' => 'btn white small')); ?>
                <?php echo $this->Html->link(__('Preview'), '/account/deals/preview/' . $deal['Deal']['id'], array('class' => 'btn white small')); ?>

                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $deal['Deal']['id']), array('class' => 'btn white delete'), __('Are you sure you want to delete %s?', $deal['Deal']['name'])); ?>
              </td>
            </tr>
            <?php $i++; ?>
          <?php endforeach; ?>
        </table>
      <?php else: ?>
      <div class="no-deals">
        <p>You currently do not have any deals</p>
        <a href="/account/deals/create" class="btn white create">Create your first deal</a>
      </div>
      <?php endif; ?>
    </div>
  </section>
</article>