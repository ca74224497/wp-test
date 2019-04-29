<?php
/**
 * Template Name: Home page
 */

/**
 * Set global vars.
 */
global $wp_country;

/**
 * Get music releases.
 */
$data = getReleases(/* page = */ 1);
?>

<div class="control" data-nonce="<?= wp_create_nonce('releases'); ?>">
  <div class="row">
    <button class="ui labeled icon orange button control__add-release">
      <i class="plus icon"></i>
      add music release
    </button>
  </div>
	<?php if (count($data['items'])): ?>
    <div class="row">
      <div class="ui green label total">TOTAL:
        <span class="amount"><?= $data['pagination']['total']; ?></span>
      </div>
      <div class="ui pagination menu inverted" data-per-page="<?= RELEASES_PER_PAGE; ?>"></div>
      <div class="ui labeled icon dropdown grey button sorting">
        <input type="hidden" name="release-sorting" />
        <i class="sort alphabet down icon"></i>
        <span class="text">Sort</span>
        <div class="menu">
        <?php foreach (getSortingOptions() as $k => $v): ?>
              <div class="item" data-value="<?= $k; ?>"><?= $v; ?></div>
        <?php endforeach; ?>
        </div>
      </div>
      <button class="ui labeled icon grey button filtering">
        <i class="filter icon"></i>
        Filtering
      </button>
    </div>
  <?php endif; ?>
</div>
<?php if (count($data['items'])): ?>
  <div class="ui segment release-container">
    <div class="ui dimmer">
      <div class="ui text massive loader">Loading</div>
    </div>
    <div class="ui special four stackable cards releases"></div>
  </div>
<?php else: ?>
  <div class="ui negative big message">
    <div class="header">
      No music release found!
    </div>
    <p>Click the &laquo;Add new music release&raquo; button to add a new music release.</p>
  </div>
<?php endif; ?>
<!--MODALS-->
<div class="ui small modal add-release">
  <div class="header">
    Add music release
  </div>
  <div class="content">
    <div class="ui form">
      <div class="ui dropdown empty"></div>
      <div class="two fields">
        <div class="field">
          <label>Name <span class="required">*</span></label>
          <input type="text" name="release-name" placeholder="Release Name" />
        </div>
        <div class="field">
          <label>Author <span class="required">*</span></label>
          <div class="ui fluid selection dropdown multiple">
            <input type="hidden" name="release-author" />
            <i class="dropdown icon"></i>
            <div class="default text">Select Author</div>
            <div class="menu">
		        <?php foreach ($data['extra']['artists'] as $k => $v): ?>
              <div class="item" data-value="<?= $k; ?>">
                <i class="microphone icon"></i><?= $v; ?>
              </div>
		        <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label>Genre <span class="required">*</span></label>
          <div class="ui fluid selection multiple dropdown">
            <input type="hidden" name="release-genre" />
            <i class="dropdown icon"></i>
            <div class="default text">Select Genre</div>
            <div class="menu">
		        <?php foreach ($data['extra']['genres'] as $k => $v): ?>
			        <?php foreach ($v as $i => $j): ?>
				        <?php if (is_scalar($j)): ?>
                  <div class="item" data-value="<?= $i; ?>">
                    <b><?= $j; ?></b>
                  </div>
				        <?php else: ?>
					        <?php foreach ($j as $m => $n): ?>
                    <div class="item" data-value="<?= $m; ?>">
                      <?= $n; ?>
                    </div>
					        <?php endforeach; ?>
				        <?php endif; ?>
			        <?php endforeach; ?>
		        <?php endforeach; ?>
            </div>
          </div>
        </div>
        <div class="field">
          <label>Format <span class="required">*</span></label>
          <div class="ui fluid selection dropdown">
            <input type="hidden" name="release-format" />
            <i class="dropdown icon"></i>
            <div class="default text">Select Format</div>
            <div class="menu">
              <?php foreach (getReleaseFormats() as $k => $v): ?>
                <div class="item" data-value="<?= $k; ?>"><?= $v; ?></div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label>Country <span class="required">*</span></label>
          <div class="ui fluid selection dropdown">
            <input type="hidden" name="release-country" />
            <i class="dropdown icon"></i>
            <div class="default text">Select Country</div>
            <div class="menu">
              <?php foreach ($wp_country->countries_list() as $k => $v): ?>
                <?php $k = strtolower($k); ?>
                <div class="item" data-value="<?= $k; ?>">
                  <i class="<?= $k; ?> flag"></i>
                  <?= $v; ?>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <div class="field">
          <label>Date <span class="required">*</span></label>
          <div class="ui fluid calendar">
            <div class="ui input left icon">
              <i class="calendar icon"></i>
              <input type="text" name="release-date" placeholder="Select Date" />
            </div>
          </div>
        </div>
      </div>
      <div class="field">
        <label>Tracklist <span class="required">*</span></label>
        <a href="#" class="ui labeled icon button add-tracklist-btn">
          <input type="hidden" name="release-tracklist" />
          <i class="plus icon"></i>
          add tracks
        </a>
      </div>
      <!--WP Ajax nonce-->
      <input type="hidden" name="nonce" value="<?= wp_create_nonce('release'); ?>" />
    </div>
  </div>
  <div class="actions">
    <div class="ui black deny button">Nope</div>
    <div class="ui green right labeled icon button add-release-btn">
      Yep, add new release
      <i class="checkmark icon"></i>
    </div>
  </div>
</div>
<div class="ui tiny modal add-tracklist">
  <div class="header">
    Add tracklist
  </div>
  <div class="content">
    <div class="ui form">
      <div class="three fields">
        <div class="field">
          <label>Track name</label>
          <input type="text" name="track-name" placeholder="Name" />
        </div>
        <div class="field">
          <label>Duration (mm:ss)</label>
          <input type="text" name="track-duration" placeholder="00:00" />
        </div>
        <div class="field">
          <label>&nbsp;</label>
          <button class="ui labeled icon button add-track-btn">
            <i class="plus icon"></i>
            Add Track
          </button>
        </div>
      </div>
    </div>
    <ul class="output"></ul>
  </div>
  <div class="actions">
    <div class="ui black button clear-tracklist-btn">Clear</div>
    <div class="ui positive right labeled icon button tracklist-okay-btn">
      Save Tracklist <i class="checkmark icon"></i>
    </div>
  </div>
</div>
<div class="ui tiny modal filtering">
  <div class="header">
    Filtering
  </div>
  <div class="content">
    <div class="ui form">
      <div class="ui dropdown empty"></div>
      <div class="field">
        <label>Genre</label>
        <div class="ui fluid selection multiple dropdown">
          <input type="hidden" name="filtering-genre" />
          <i class="dropdown icon"></i>
          <div class="default text">Select Genre</div>
          <div class="menu">
		      <?php foreach ($data['extra']['genres'] as $k => $v): ?>
			      <?php foreach ($v as $i => $j): ?>
				      <?php if (is_scalar($j)): ?>
                <div class="item" data-value="<?= $i; ?>">
                  <b><?= $j; ?></b>
                </div>
				      <?php else: ?>
					      <?php foreach ($j as $m => $n): ?>
                  <div class="item" data-value="<?= $m; ?>">
                    <?= $n; ?>
                  </div>
					      <?php endforeach; ?>
				      <?php endif; ?>
			      <?php endforeach; ?>
		      <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="field">
        <label>Format</label>
        <div class="ui fluid selection dropdown">
          <input type="hidden" name="filtering-format" />
          <i class="dropdown icon"></i>
          <div class="default text">Select Format</div>
          <div class="menu">
            <?php foreach (getReleaseFormats() as $k => $v): ?>
              <div class="item" data-value="<?= $k; ?>"><?= $v; ?></div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="field">
        <label>Country</label>
        <div class="ui fluid selection dropdown">
          <input type="hidden" name="filtering-country" />
          <i class="dropdown icon"></i>
          <div class="default text">Select Country</div>
          <div class="menu">
            <?php foreach ($wp_country->countries_list() as $k => $v): ?>
              <?php $k = strtolower($k); ?>
              <div class="item" data-value="<?= $k; ?>">
                <i class="<?= $k; ?> flag"></i>
                <?= $v; ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="two fields">
        <div class="field">
          <label>Date From</label>
          <div class="ui fluid calendar">
            <div class="ui input left icon">
              <i class="calendar icon"></i>
              <input type="text" name="filtering-date-from" placeholder="Select Date" />
            </div>
          </div>
        </div>
        <div class="field">
          <label>Date To</label>
          <div class="ui fluid calendar">
            <div class="ui input left icon">
              <i class="calendar icon"></i>
              <input type="text" name="filtering-date-to" placeholder="Select Date" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="actions">
    <div class="ui black deny button filtering-reset-btn">Reset</div>
    <div class="ui positive right labeled icon button filtering-okay-btn">
      Filtering <i class="checkmark icon"></i>
    </div>
  </div>
</div>
<!--/MODALS-->

<script>
  var releases = <?= json_encode($data); ?>;
</script>

<!--TEMPLATES-->
<script id="releases-tpl" type="text/template">
  {{foreach i in items}}
    <div class="card">
      <div class="blurring dimmable image">
        <div class="ui dimmer">
          <div class="content">
            <div class="center">
              <div class="ui dropdown">
                <button class="ui right labeled icon button card__dropdown-button">
                  <i class="down arrow icon"></i>
                  Show release tracklist
                </button>
                <div class="menu card__tracklist">
                  {{foreach track in i.tracks}}
                    <div class="item">{{track.name}}</div>
                  {{end}}
                </div>
              </div>
            </div>
          </div>
        </div>
        <img src="<?= get_theme_root_uri(); ?>/my/assets/images/release.png" />
      </div>
      <div class="content">
        <div class="ui red ribbon big label">
          {{foreach author in i.authors}}
            <a href="{{author.page}}" target="_blank">
              {{author.name}}
            </a>
            {{if $index < i.authors.length - 1}}&comma;{{fi}}
          {{end}}
        </div>
        <h3 class="card__release-title">
          <a href="{{i.url}}" class="card__release-link" target="_blank">{{i.title}}</a>
        </h3>
      </div>
    </div>
  {{end}}
</script>
<script id="pagination-tpl" type="text/template">
  <a class="item nav prev">←</a>
  {{foreach i in items}}
    <a class="item {{if i == active}}active{{fi}}" data-index="{{i}}">{{i}}</a>
  {{end}}
  <a class="item nav next">→</a>
</script>
<!--/TEMPLATES-->