<article id="my-account" class="canvas deals-index clearfix">
  <?php echo $this->element('default/account_navigation'); ?>
  <section id="my-deals">
    <div class="content">
      <?php if($liveDeal || $draftDeals || $completedDeals): ?>
      <?php if ($liveDeal): ?>
      <h2 class="gradient brown">Live Deal</h2>
      <table cellpadding="0" cellspacing="0">
        <thead class="">
          <th class="first">Deal Name</th>
          <th class="status">Status</th>
          <th class="last" >Manage Deal</th>
        </thead>
        <?php
          $i = 0;
          foreach ($liveDeal as $deal): ?>
            <?php if( $deal['Status']['status'] == 'deleted') { continue; } ?>
            <tr class="<?php echo ($i%2) ? 'odd' : 'even'; ?>">

              <td><?php echo $deal['Deal']['product_name']; ?>&nbsp;</td>
              <td class="status"><?php echo $deal['Status']['status']; ?>&nbsp;</td>

              <td class="actions">
                <?php // echo $this->Html->link(__('Add Images'), '/account/deals/edit/' . $deal['Deal']['id'] . 'images/manage', array('class' => 'btn white small')); ?>
                <?php echo $this->Html->link(__('View Orders'), '/account/deals/' . $deal['Deal']['id'] . '/orders', array('class' => 'btn white small')); ?>
              </td>
            </tr>
            <?php $i++; ?>
          <?php endforeach; ?>
      </table>
      <?php endif; ?>
      <?php if ($draftDeals): ?>
      <h2 class="gradient brown">Draft Deals</h2>
      <table cellpadding="0" cellspacing="0">
        <thead class="">
          <th class="first">Deal Name</th>
          <th class="status">Status</th>
          <th class="last" >Manage Deal</th>
        </thead>
        <?php
          $i = 0;
          foreach ($draftDeals as $deal): ?>
            <?php if( $deal['Status']['status'] == 'deleted') { continue; } ?>
            <tr class="<?php echo ($i%2) ? 'odd' : 'even'; ?>">

              <td><?php echo $deal['Deal']['product_name']; ?>&nbsp;</td>
              <td class="status"><?php echo $deal['Status']['status']; ?>&nbsp;</td>

              <td class="actions">
                <?php // echo $this->Html->link(__('Add Images'), '/account/deals/edit/' . $deal['Deal']['id'] . 'images/manage', array('class' => 'btn white small')); ?>
                <?php echo $this->Html->link(__('Edit'), '/account/deals/edit/' . $deal['Deal']['id'], array('class' => 'btn white small')); ?>
                <?php echo $this->Html->link(__('Preview'), '/account/deals/preview/' . $deal['Deal']['id'], array('class' => 'btn white small')); ?>

                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $deal['Deal']['id']), array('class' => 'btn white delete'), __('Are you sure you want to delete "%s"?', $deal['Deal']['product_name'])); ?>
              </td>
            </tr>
            <?php $i++; ?>
          <?php endforeach; ?>
        </table>
        <?php endif; ?>
        <?php if ($completedDeals): ?>
        <h2 class="gradient brown">Completed Deals</h2>
        <table cellpadding="0" cellspacing="0">
          <thead class="">
            <th class="first">Deal Name</th>
            <th class="status">Status</th>
            <th class="last" >Manage Deal</th>
          </thead>
          <?php
            $i = 0;
            foreach ($completedDeals as $deal): ?>
              <?php if( $deal['Status']['status'] == 'deleted') { continue; } ?>
              <tr class="<?php echo ($i%2) ? 'odd' : 'even'; ?>">

                <td><?php echo $deal['Deal']['product_name']; ?>&nbsp;</td>
                <td class="status"><?php echo $deal['Status']['status']; ?>&nbsp;</td>

                <td class="actions">
                  <?php echo $this->Html->link(__('View Orders'), '/account/deals/' . $deal['Deal']['id'] . '/orders', array('class' => 'btn white small')); ?>
                </td>
              </tr>
              <?php $i++; ?>
            <?php endforeach; ?>
        </table>
      <?php endif; ?>
      <?php else: ?>
      <div class="no-deals">
        <p>You currently do not have any deals</p>
        <a href="/account/deals/create" class="btn white create">Create your first deal</a>
      </div>
      <?php endif; ?>
    </div>
  </section>
</article>