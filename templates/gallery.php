<?php
ob_start();
?>

<div class="lightbox">
    <div class="left">
        <button class="icon-button filled" id="back"><span class="icon"><img src="/icons/arrow_back_ios.svg" alt="Back"></span></button>
        <button class="icon-button filled" id="close"><span class="icon"><img src="/icons/close.svg" alt="Close"></span></button>
        <button class="icon-button filled" id="caption"><span class="icon"><img src="/icons/subtitles.svg" alt="Show caption"></span></button>
    </div>
    <div class="middle">
        <div class="img"><img src="" alt=""></div>
        <div class="caption"><p></p></div>
    </div>
    <div class="right">
        <button class="icon-button filled" id="forward"><span class="icon"><img src="/icons/arrow_forward_ios.svg" alt="Forward"></span></button>
    </div>
</div>

<div id="gallery">
  <?php
  $image_number = 1;
  
  if (isset($images) && is_array($images)) {
    foreach ($images as $image) {
      $image = str_replace('build/', '', $image);
      echo '
      <div class="gallery-item">
          <div class="content">
              <picture id="photo-' . $image_number . '" class="photo clickable">
                  <source srcset="' . $image . '.webp' . '" type="image/webp">
                  <img src="' . $image . '.jpg' . '" loading="lazy">
              </picture>
              <div class="click-plane"></div>
          </div>
      </div>
      ';

      ++$image_number;
    }
  }
  ?>
</div>

<?php
ob_end_flush();
?>