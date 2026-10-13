    <?php if(!empty($banner) && count($banner) > 0){ ?>
        <section class="wide-section section-slider press-row" id="press-release">
          <div class="page-inner">

            <div id="press-date">
            <p>CDI LABS NEWS <span>|</span></p>
            </div>

            <?php
              $bannerCount = 1;
              foreach ($banner as $row){ 
                $bSlide = $bannerCount > 1 ? ' slide-'.$bannerCount.' fade-out' : ' slide-'.$bannerCount.' playing';
                $month = $webhelper->GetMonthShortName($row['month']);
                $day = ltrim($row['day'],'0');
                $title = $webhelper->CurRightString($row["title"],80);
                $titleLength = strlen($title);
                if($titleLength > 80){
                  $endSpace = strrpos($title,' ');
                  $stickerTitle = substr($title,0,$endSpace).'...';
                }else{
                  $stickerTitle = $title;
                }
                if(empty($row['endday'])){
                  if($row['type'] == 1){
                    $cat = 'News';
                    $url = $row['filename'] == 'none' ? "target='_blank' href='" . $row['url'] . "'" : "href='/news-events/" . $row['slugurl'] . "'";
                  }
                  if($row['type'] == 2){
                    $cat = 'Press Release';
                    $url = "href='/news-events/" . $row['slugurl'] . "'";
                  }
                }else{
                  if($row['type'] == 1){
                    $cat = 'Conference';
                    $url = "href='/event/" . $row['slugurl'] . "'";
                  }
                  if($row['type'] == 2){
                    $cat = 'Meeting';
                    $url = "href='/event/" . $row['slugurl'] . "'";
                  }
                  if($row['type'] == 3){
                    $cat = 'Webinar';
                    $url = "href='/event/" . $row['slugurl'] . "'";
                  }
                }
            ?>
               <ul class="slide<?php echo $bSlide; ?>">
                 <li><span><?php echo $month.' '.$day.', '.$row['year']; ?></span><a class="smooth-hover" <?php echo $url; ?>><span><?php echo '<em>'.$cat.':  </em>  ' .$stickerTitle ?></span></a></li>
               </ul>
            <?php
                $bannerCount++;
              }
            ?>

            <a href="/news-events/news" class="view-all smooth-hover">all news<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg></a>

            <div class="slide-nav"></div>

          </div>
     
        </section>

    <?php } ?>
