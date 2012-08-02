<article id="deal" class="clearfix">
    <div id="main-information" class="canvas">
        <div class="clearfix">
            <div class="left title-tagline">
                <h1 class="company-logo"><img src="<?php echo $logo['path_resized']; ?>" /></h1>
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
               
                  <img class="picture" src="<?php echo $productImage['path_resized'] ?>"  alt="">
                
            </div>
            <div class="details">
                <ul>
                    <?php if ($data['Deal']['product_detail_1']): ?>
                        <li class="product-detail"><?php echo $data['Deal']['product_detail_1'] ?></li>
                    <?php endif; ?>
                    <?php if ($data['Deal']['product_detail_2']): ?>
                        <li class="product-detail"><?php echo $data['Deal']['product_detail_2'] ?></li>
                    <?php endif; ?>
                    <?php if ($data['Deal']['product_detail_3']): ?>
                        <li class="product-detail"><?php echo $data['Deal']['product_detail_3'] ?></li>
                    <?php endif; ?>
                    <?php if ($data['Deal']['product_detail_4']): ?>
                        <li class="product-detail"><?php echo $data['Deal']['product_detail_4'] ?></li>
                    <?php endif; ?>
                    <?php if ($data['Deal']['product_detail_5']): ?>
                        <li class="product-detail"><?php echo $data['Deal']['product_detail_5'] ?></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="buy-now-container">
                <div class="gradient green price-buy clearfix">
                    <div class="price"><span class="dollar">$</span><?php echo $data['Deal']['price']; ?></div>
                    <?php if($data['Deal']['time_left']): ?>
                    <button class="btn white buy-now">Buy Now</button>
                    <?php else: ?>
                    <div class="ended">Deal Has Ended</div>
                    <?php endif; ?>
                </div>
                <div class="time-lock-status canvas clearfix">
                    <div class="time left">
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
                    <div class="right bought-container">
                        <?php if ($data['Deal']['num_purchased']): ?>
                        <div class="bought">
                            <span class="number">
                                <?php echo $data['Deal']['num_purchased']; ?>
                            </span>
                            bought
                        </div>
                        <?php else: ?>
                        <br>
                        <?php endif; ?>
                        <?php $leftToUnlock = $data['Deal']['minimum'] - $data['Deal']['num_purchased']; ?>
                        <?php if ($leftToUnlock <= 0 ): ?>

                        <?php else: ?>
                        <div class="locked">
                            <div class="to-unlock"><?php echo $data['Deal']['minimum'] - $data['Deal']['num_purchased'] ?> more needed to unlock</div>
                        </div>
                        <?php endif; ?>
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
                    <li><span class="number gradient brown">1</span>Purchase</li>
                    <li><span class="number gradient brown">2</span>Seller ships to your door</li>
                    <li><span class="number gradient brown">3</span>Share with a friend</li>
                </ul>
            </section>
            <section class="canvas bottom">
                <h3 class="gradient green"><span>The Fine Print</span></h3>
                <ul class="rules">
                    <li>Maximum 1 offer per customer</li>
                    <li>Offer is immediately redeemed once deal is unlocked</li>
                </ul>
            </section>
            <?php /*
            <section class="canvas bottom">
                <h3 class="gradient green"><span>Social Media</span></h3>
                <ul id="social" class="clearfix">
                    <?php if(!empty($data['Business']['url_facebook'])): ?>
                        <li class="facebook">
                            <a href="http://<?php echo $data['Business']['url_facebook'] ?>"><img src="/img/social_facebook.png" alt=""></a>
                        </li>
                    <?php endif ?>
                    <?php if(!empty($data['Business']['url_twitter'])): ?>
                        <li class="facebook">
                            <a href="http://<?php echo $data['Business']['url_twitter'] ?>"><img src="/img/social_twitter.png" alt=""></a>
                        </li>
                    <?php endif ?>
                    <?php if(!empty($data['Business']['url_yelp'])): ?>
                        <li class="facebook">
                            <a href="http://<?php echo $data['Business']['url_yelp'] ?>"><img src="/img/social_yelp.png" alt=""></a>
                        </li>
                    <?php endif ?>
                    
                </ul>
            </section>
        */ ?>
        </aside>
    </div>
</article>