<?php
ob_start();
?>

<br><br><br>
<div class="columns-md gap-10">
    
  <?php
  $image_number = 1;
  
  if (isset($images) && is_array($images)) {
    foreach ($images as $image) {
      $image = str_replace('build/', '', $image);
      echo '
      <div class="mb-10">
        <picture id="photo-' . $image_number . '">
            <source srcset="' . $image . '.webp' . '" type="image/webp">
            <img src="' . $image . '.jpg' . '" loading="lazy">
        </picture>
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