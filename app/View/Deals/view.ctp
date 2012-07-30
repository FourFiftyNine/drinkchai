<article id="deal" class="clearfix">
    <div id="main-information" class="canvas">
        <div class="clearfix">
            <div class="left title-tagline">
                <h1 class="company-logo"><img src="<?php echo $data['Image']['logo']['path_resized']; ?>" /></h1>
                <?php /* ?>
                <h2 class="product-name"><?php echo $data['Deal']['product_name']; ?></h2>
                */ ?>
            </div>
            <?php 
                $percentage = ($data['Deal']['price'] / $data['Deal']['original_price']);
                $percentage = round($percentage * 100);
             ?>
            <div class="discount">
                <?php echo $percentage; ?><span class="percentage">%</span><div class="off">Off</div>
            </div>
            <div id="share" class="">
                <div class="fb-like" data-send="false" data-layout="box_count" data-width="" data-show-faces="false"></div>
                <a href="https://twitter.com/share" class="twitter-share-button" data-text="Get great Tea deals at " data-url="http://drinkchai.com" data-via="drink_chai" data-lang="en" data-related="anywhereTheJavascriptAPI" data-count="vertical"></a>
                <div id="pinterest">
                    <a href="http://pinterest.com/pin/create/button/?url=<?php echo $this->Html->url(null, true); ?>&media=<?php echo Router::url('/', true) ?>img/test-deal-image.png" class="pin-it-button" count-layout="vertical"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>
                </div>

<!--                 <div id="plusone">
                    <g:plusone size="tall"></g:plusone>
                </div> -->
            </div>
        </div>
        <div class="deal-information">
            <div class="slideshow">
                <img class="frame" src="/img/deal-image-frame.png" alt="">
                <?php foreach($data['Image'] as $image): ?>
                  <?php if ($image['deleted'] || $image['is_logo']) { continue; } ?>
                  <img class="picture" src="<?php echo $image['path_resized'] ?>" style="position: relative; top: <?php echo $image['offset'] ?>px;" alt="">
                <?php endforeach; ?>
                
            </div>
            <div class="details">
                <p><?php echo $data['Deal']['details'] ?></p>
            </div>
            <div class="buy-now-container">
                <div class="gradient green price-buy clearfix">
                    <div class="price"><span class="dollar">$</span><?php echo $data['Deal']['price']; ?></div>
                    <button class="btn white buy-now">Buy Now</button>
                </div>
                <div class="time-lock-status canvas clearfix">
                    <div class="time left">
                        <?php if ($data['Deal']['time_left']): ?>
                        <div class="label">Time Left</div>
                        <div data-dealid="<?php echo $data['Deal']['id'] ?>" class="time-left">
                            <?php //echo $data['Deal']['end_date'] ?>
                            <?php $timeLeft = $data['Deal']['time_left']; ?>
                            <?php if ($timeLeft['days']): ?>
                            <div class="days"><?php echo $timeLeft['days']; ?></div>
                            <?php endif; ?>
                            <div class="countdown">
                                <?php /*
                                <span class="hours"><?php echo $timeLeft['hours']; ?></span>
                                <span class="colon">:</span>
                                <span class="minutes"><?php echo $timeLeft['minutes']; ?></span>
                                <span class="colon">:</span>
                                <span class="seconds"><?php echo $timeLeft['seconds']; ?></span>
                                */ ?>
                                <span class="hours"></span><span class="colon">:</span><span class="minutes"></span><span class="colon">:</span><span class="seconds"></span>
                            </div>
                        </div>
                        <?php else: ?>
                            <div class="time-left">Deal Has Ended</div>
                        <?php endif; ?>
                    </div>
                    <div class="right bought-container">
                        <div class="bought">
                            <span class="number">
                                55
                            </span>
                            bought
                        </div>  
                        <div class="locked">
                            <div class="to-unlock">3 more needed to unlock</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="additional-information" class="clearfix">
        <div id="product-company-information" class="canvas left">
            <div class="the-deal">
                <h1 class="tag"><span><?php echo $data['Deal']['product_name']; ?></span></h1>
                <p class="deals-description">
                    <?php echo $data['Deal']['product_description']; ?>
                </p>
            </div>
            <div class="tea-company-name">
                <h1 class="tag deals-company-name"><span><?php echo $data['Business']['name']; ?></span></h1>
                <p class="company-description">
                <?php echo $data['Business']['description']; ?>
                </p>
            </div>
        </div>
        <aside id="sidebar" class="left">
            <section class="canvas bottom">
                <h3 class="gradient green"><span>How It Works</span></h3>
                <ul class="how-it-works">
                    <li><span class="number gradient green">1</span>Purchase.</li>
                    <li><span class="number gradient green">2</span>Seller ships to your door.</li>
                    <li><span class="number gradient green">3</span>Share with a friend.</li>
                </ul>
            </section>
            <section class="canvas bottom">
                <h3 class="gradient green"><span>General Offer Rules</span></h3>
                <ul>
                    <li>1</li>
                    <li>2</li>
                    <li>3</li>
                </ul>
            </section>
            <section class="canvas bottom">
                Facebook / Twitter / Yelp
            </section>
        </aside>
    </div>
</article>