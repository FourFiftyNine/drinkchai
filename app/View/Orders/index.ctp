<article id="my-account" class="order-history canvas clearfix">
  <?php echo $this->element('default/account_navigation', array('user'=> $user)); ?>
  <?php 
  /*
  * Business User Top, Normal User Below
  **/
   ?>
  <?php if ('business' == $user['User']['user_type']): ?>
    <section id="my-orders">
      
    </section>
  <?php else: ?> <?php // @CUSTOMERS ?>
    <section id="my-orders">
      <h2 class="gradient brown">My Orders</h2>
      <?php if($orders): ?>
      <table cellpadding="0" cellspacing="0">
        <thead class="">
          <th class="first date">Date</th>
          <th class="item">Item</th>
          <th class="status">Status</th>
          <th class="cost">Cost</th>
          <th class="last manage" >View Deal</th>
        </thead>
        <?php
          $i = 0;
          foreach ($orders as $order): ?>
            <?php if( $order['Status']['status'] == 'deleted') { continue; } ?>
            <tr class="<?php echo ($i%2) ? 'odd' : 'even'; ?>">
              <td class="date"><?php echo $this->Time->format('M jS, Y', $order['Order']['modified']) ?></td>

              <td><?php echo $order['Deal']['product_name']; ?></td>
              <td class="status"><?php echo $order['Status']['status']; ?></td>
              <td class="cost"><?php echo $this->Number->currency($order['Deal']['price'] * $order['Order']['quantity']); ?></td>
              <td class="actions">
                <?php // echo $this->Html->link(__('Add Images'), '/account/deals/edit/' . $order['Order']['id'] . 'images/manage', array('class' => 'btn white small')); ?>
                <?php echo $this->Html->link(__('View Order Details'), '/account/orders/view/' . $order['Order']['id'], array('class' => 'btn white small')); ?>
              </td>
            </tr>
            <?php $i++; ?>
          <?php endforeach; ?>
        </table>
      <?php else: ?>
      <div class="no-orders">
        <p>You currently do not have any orders.</p>
      </div>
      <?php endif; ?>
    </section>
  <?php endif; ?>
</article>