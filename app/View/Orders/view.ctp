<article id="my-account" class="order-view dashboard canvas clearfix">
  <?php echo $this->element('default/account_navigation', array('user'=> $user)); ?>
  <?php 
  /*
  * Business User Top, Normal User Below
  **/
   ?>
  <?php if ('business' == $user['User']['user_type']): ?>
    <section id="my-order">
      
    </section>
  <?php else: ?> <?php // @CUSTOMERS ?>
    <div id="my-order">
      <h1 class="">Order #<?php echo $data['Order']['id']; ?></h1>
     <div>
       <?php echo $this->element('stripped/checkout_top', array('showDetails' => true)); ?>
       <h2 class="gradient brown">Purchase</h2>
       <div class="order-items">
         <table>
           <tr>
             <th class="deal-details left-align">Item</th>
             <th class="price">Price</th>
             <th class="quantity">Quantity</th>
             <th class="total right-align">Total</th>
           </tr>
           <tr class="line-item">
             <td class="deal-details left-align">
               <?php //echo $this->element('global/deal_details'); ?>
               <?php echo $data['Deal']['checkout_line_item']; ?>
             </td>
             <td>
               <?php echo $this->Number->currency($data['Deal']['price']) ?>
             </td>
             <td class="quantity">
               <?php echo $quantity; ?>
             </td>
             <td class="total right-align">
               <?php echo $this->Number->currency($data['Deal']['price'] * $quantity); ?>
             </td>
           </tr>
           <tr class="grand-total-row">
            <td colspan="3"></td>
             <td class="grand-total right-align" colspan="1">Total: <span class="grand-total-amount"><?php echo $this->Number->currency($data['Deal']['price'] * $quantity); ?></span></td>
           </tr>
         </table>
       </div>
       <section id="billing-information" class="right">
         <h2 class="gradient brown">Billing Address</h2>
         <?php $billAdd = $billingAddress; ?>
         <div class="label">Name</div>
         <div><?php echo $billAdd['firstname'] . ' ' . $billAdd['lastname']?></div>
         <div class="label">Address One</div>
         <div><?php echo $billAdd['address_one'] ?></div>
         <?php if ($billAdd['address_two']): ?>
           <div class="label">Address Two</div>
           <div><?php echo $billAdd['address_two']; ?></div>
        <?php endif; ?>
         <div class="label">City, State Zip</div>
         <div><?php echo $billAdd['city'] . ', ' . $billAdd['state'] . ' ' . $billAdd['zip'];   ?></div>
       </section>
       <section id="shipping-information" class="left">
         <h2 class="gradient brown">Shipping Address</h2>
         <?php $shAdd = $shippingAddress['ShippingAddress']; ?>
         <div class="label">Name</div>
         <div><?php echo $shAdd['firstname'] . ' ' . $shAdd['lastname']?></div>
         <div class="label">Address One</div>
         <div><?php echo $shAdd['address_one'] ?></div>
         <?php if ($shAdd['address_two']): ?>
           <div class="label">Address Two</div>
           <div><?php echo $shAdd['address_two']; ?></div>
        <?php endif; ?>
         <div class="label">City, State Zip</div>
         <div><?php echo $shAdd['city'] . ', ' . $shAdd['state'] . ' ' . $shAdd['zip'];   ?></div>
       </section>
       <section id="billing-information" class="left">
         <h2 class="gradient brown">Payment Information</h2>
         <?php if ($data['BillingAddress']['firstname']): ?>
           <div class="label">Name on Card</div>
           <div> <?php echo $data['BillingAddress']['firstname'] ?></div>
           <div class="label">Card Type</div>
           <div> <?php echo $data['Billing']['card_type'] ?></div>
           <div class="label">Card Number</div>
           <div>xxxx xxxx xxxx <?php echo $data['Billing']['card_number_last_four']; ?></div>
         <?php else: ?>
           <p>No billing information</p>
         <?php endif; ?>
       </section>
     </div>
    </div>
  <?php endif; ?>
</article>