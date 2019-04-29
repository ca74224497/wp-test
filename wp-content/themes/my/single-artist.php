<?php
/**
 * Template Name: Artist
 */

/**
 * Save this page for "last_seen" shortcode.
 */
rememberPage(get_the_ID());
?>
<?php
  get_header();
?>
<!--/HEADER-->

<!--CONTENT-->
<div class="artist">
  <!--SHORTCODE "LAST_SEEN"-->
	<?= do_shortcode('[last_seen current="' . get_the_ID() . '"]'); ?>
  <!--/SHORTCODE "LAST_SEEN"-->
  <div class="ui card artist__image">
    <div class="image">
      <img src="<?= get_theme_root_uri(); ?>/my/assets/images/artist.png" />
    </div>
    <div class="content">
      <div class="header center aligned artist__title">
        <?php the_title(); ?>
      </div>
    </div>
  </div>
  <p class="artist__description">
    <?php if (have_posts()): ?>
      <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>
    <?php endif; ?>
  </p>
  <div class="artist__songs">
    <div class="ui huge header center aligned">List of Songs:</div>
    <?php foreach (getArtistSongs(get_the_ID()) as $item): ?>
      <div class="artist__songs-item">
        <div class="ui large header">
          <?= $item['title']; ?>
          <span class="artist__songs-date">
            (<?= date('d.m.Y', strtotime($item['date'])); ?>)
          </span>
        </div>
        <div class="ui list">
          <?php foreach ($item['tracks'] as $track): ?>
            <div class="item">
              <i class="headphones large icon"></i>
              <?= $track['name']; ?> (<?= $track['duration']; ?>)
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<!--/CONTENT-->

<!--FOOTER-->
<?php
  get_footer();
?>