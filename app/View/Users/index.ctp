<article id="my-account" class="dashboard canvas clearfix">
  <?php echo $this->element('default/account_navigation', array('user'=> $user)); ?>
  <?php 
  /*
  * Business User Top, Normal User Below
  **/
   ?>
  <?php if ('business' == $user['User']['user_type']): ?>
    <section id="business-information" class="left">
      <h2 class="gradient brown">Business Information<a class="btn white" href="/account/edit">Edit</a></h2>
      <div class="content">
        <div class="label">Business Name</div>
        <div class="text"><?php echo $user['Business']['name']; ?></div>
        
        <div class="label">Email Address</div>
        <div class="text"><?php echo $user['User']['email']; ?></div>
        <div class="clearfix fieldset">
          <div class="left">
            <div class="label">First Name</div>
            <div class="text"><?php echo $user['User']['firstname']; ?></div>
          </div>

          <div class="left">
            <div class="label">Last Name</div>
            <div class="text"><?php echo $user['User']['lastname']; ?></div>
          </div>
        </div>
        <div class="label">Website</div>
        <div class="text"><?php echo $user['Business']['url_website']; ?></div>

        <div class="label">Facebook Page</div>
        <div class="text"><?php echo $user['Business']['url_facebook']; ?></div>

        <div class="label">Twitter</div>
        <div class="text"><?php echo $user['Business']['url_twitter']; ?></div>

        <div class="label">Yelp Url</div>
        <div class="text"><?php echo $user['Business']['url_yelp']; ?></div>
      </div>
    </section>
        <?php if ($addresses):?>
          <?php foreach ($addresses as $address): ?>
            <section id="business-address" class="right">
              <h2 class="gradient brown"><?php echo $address['Address']['type']; ?> Address<a class="btn white" href="/account/edit">Edit</a></h2>
              <div class="content">
                <div class="label">Street Address</div>
                <div class="text"><?php echo $address['Address']['address_one']; ?></div>
                <div class="label">Street Address 2</div>
                <div class="text"><?php echo $address['Address']['address_two']; ?></div>
                <div class="label">City</div>
                <div class="text"><?php echo $address['Address']['city']; ?></div>
                <div class="label">State</div>
                <div class="text"><?php echo $address['Address']['state']; ?></div>
                <div class="label">Zip</div>
                <div class="text"><?php echo $address['Address']['zip']; ?></div>
              </div>
            </section>
          <?php endforeach; ?>
        <?php else: ?>
          <section id="business-address" class="right">
            <h2 class="gradient brown">Address</h2>

            <div class="content">
              <p>Please create an address for your business.</p>
              <a href="/account/edit" class="btn white create">Add an Address</a>
            </div>
          </section>
        <?php endif; ?>

  <?php else: ?>
      <?php if($user['User']['facebook_id']): ?>
        <aside id="picture-container">
          <div class="picture-border"></div>
          <?php echo $this->Html->image('http://graph.facebook.com/' . $user['User']['facebook_id'] . '/picture?type=large', array('class' => 'profile-picture')); ?>
        </aside>
      <?php endif; ?>
      <section id="personal-information" class="left">
        <h2 class="gradient brown">personal information</h2>
        <div class="label">name</div>
        <div> <?php echo $user['User']['firstname'] . ' ' . $user['User']['lastname']; ?></div>

        <div class="label">email</div>
        <div><?php echo $user['User']['email']; ?></div>
      </section>
      <section id="billing-information" class="right">
        <h2 class="gradient brown">personal information</h2>
        <div class="label">name</div>
        <div> <?php echo $user['User']['firstname'] . ' ' . $user['User']['lastname']; ?></div>

        <div class="label">email</div>
        <div><?php echo $user['User']['email']; ?></div>
      </section>
      <section id="email-notifications">
        <h2 class="gradient brown">email notifications</h2>
        <p class="name"><div class="label">name</div><br /><?php echo $user['User']['firstname'] . ' ' . $user['User']['lastname']; ?></p>
        <p class="email"><div class="label">email</div><br /><?php echo $user['User']['email']; ?></p>
      </section>
  <?php endif; ?>

</article>
 