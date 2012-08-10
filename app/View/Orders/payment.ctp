<div id="checkout" class="review canvas">
  <?php echo $this->Form->create(array('url' => $postUrl)) ?>
  <?php foreach ($AuthNetHiddenFields as $name => $value): ?>
    <?php echo $this->Form->hidden('', array(
    'value' => $value, 
    'name'  => $name,
    'id'    => $name
    )) ?>
  <?php endforeach; ?>
  <?php $prefill = true; ?>
  <?php echo '
  <fieldset>
      <div>
          <label>Credit Card Number</label>
          <input type="text" class="text" size="15" name="x_card_num" value="'.($prefill ? '6011000000000012' : '').'"></input>
      </div>
      <div>
          <label>Exp.</label>
          <input type="text" class="text" size="4" name="x_exp_date" value="'.($prefill ? '04/17' : '').'"></input>
      </div>
      <div>
          <label>CCV</label>
          <input type="text" class="text" size="4" name="x_card_code" value="'.($prefill ? '782' : '').'"></input>
      </div>
  </fieldset>
  <fieldset>
      <div>
          <label>First Name</label>
          <input type="text" class="text" size="15" name="x_first_name" value="'.($prefill ? 'John' : '').'"></input>
      </div>
      <div>
          <label>Last Name</label>
          <input type="text" class="text" size="14" name="x_last_name" value="'.($prefill ? 'Doe' : '').'"></input>
      </div>
  </fieldset>
  <fieldset>
      <div>
          <label>Address</label>
          <input type="text" class="text" size="26" name="x_address" value="'.($prefill ? '123 Main Street' : '').'"></input>
      </div>
      <div>
          <label>City</label>
          <input type="text" class="text" size="15" name="x_city" value="'.($prefill ? 'Boston' : '').'"></input>
      </div>
  </fieldset>
  <fieldset>
      <div>
          <label>State</label>
          <input type="text" class="text" size="4" name="x_state" value="'.($prefill ? 'MA' : '').'"></input>
      </div>
      <div>
          <label>Zip Code</label>
          <input type="text" class="text" size="9" name="x_zip" value="'.($prefill ? '02142' : '').'"></input>
      </div>
      <div>
          <label>Country</label>
          <input type="text" class="text" size="22" name="x_country" value="'.($prefill ? 'US' : '').'"></input>
      </div>
  </fieldset>
  <input type="submit" value="BUY" class="submit buy">
  '?>
</div>