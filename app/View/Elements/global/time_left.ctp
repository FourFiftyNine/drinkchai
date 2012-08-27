  <div class="time clearfix">
      <?php if ($data['Deal']['time_left']): ?>
      <div class="label">Time Left</div>
      <?php $timeLeft = $data['Deal']['time_left']; ?>
      <div data-dealid="<?php echo $data['Deal']['id'] ?>" class="time-left<?php if($timeLeft['days']): echo ' days-left'; endif; ?>">
          <?php //echo $data['Deal']['end_date'] ?>
          <?php if ($timeLeft['days']): ?>
          <div class="days"><?php echo $timeLeft['days']; ?></div>
          <?php endif; ?>
          <div class="countdown">

              <!-- <span class="hours"></span><span class="colon">:</span><span class="minutes"></span><span class="colon">:</span><span class="seconds"></span> -->
          </div>
      </div>
      <div id="endtime" class="hidden"><?php echo $data['Deal']['end_date'] . ' ' . $data['Deal']['end_time'] ?></div>
      <?php else: ?>
          <div class="time-left no-time">Deal Has Ended</div>
      <?php endif; ?>
  </div>