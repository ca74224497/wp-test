<?php
/**
 * Template Name: Release
 */

/**
 * Get current release.
 */
$release = getReleases(
    /* all pages = */ 0,
    /* extra data = */ false,
    /* specific post = */ [get_the_ID()],
    /* raw data = */ false
)['items'][0];

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
<div class="release">
  <!--SHORTCODE "LAST_SEEN"-->
	<?= do_shortcode('[last_seen current="' . get_the_ID() . '"]'); ?>
  <!--/SHORTCODE "LAST_SEEN"-->
  <div class="release__info">
    <table class="ui inverted table">
      <thead>
        <tr>
          <th colspan="2"><?= the_title(); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Author</td>
          <td>
            <?php foreach ($release['authors'] as $author): ?>
              <a href="<?= $author['page']; ?>" target="_blank">
                  <?= $author['name']; ?>
              </a> /
            <?php endforeach; ?>
          </td>
        </tr>
        <tr>
          <td>Genre</td>
          <td><?= $release['genres']; ?></td>
        </tr>
        <tr>
          <td>Format</td>
          <td><?= $release['format']; ?></td>
        </tr>
        <tr>
          <td>Country</td>
          <td>
	          <?= $release['country']; ?>&nbsp;
            <i class="<?= strtolower($release['country']); ?> flag"></i>
          </td>
        </tr>
        <tr>
          <td>Date</td>
          <td><?= $release['date']; ?></td>
        </tr>
        <tr>
          <td>Tracklist</td>
          <td>
            <ul class="release__tracklist">
              <?php foreach ($release['tracks'] as $track): ?>
                <li class="release__track">
                    <?= $track['name']; ?> (<?= $track['duration']; ?>)
                </li>
              <?php endforeach; ?>
            </ul>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!--/CONTENT-->

<!--FOOTER-->
<?php
  get_footer();
?>