<?php
/**
 * Load before parent functions.php.
 */

/**
 * Register scripts and styles for current theme.
 */
function my_theme_assets() {
	/**
	 * Remove useless parent scripts and styles.
	 */
	wp_deregister_style('fino-skin-red');
	wp_deregister_style('fino-responsive');
	wp_deregister_style('font-awesome');
	wp_deregister_style('animate');
	wp_deregister_style('bootstrap');
	wp_deregister_style('fino-font');
	wp_deregister_style('fino-style');
	wp_deregister_style('wp-block-library');
	wp_deregister_script('wp-embed');
	wp_deregister_script('bootstrap-js');
	wp_deregister_script('imagesloaded');
	wp_deregister_script('isotope');
	wp_deregister_script('fino-custom-js');

	/**
	 *  Relocate jQuery to footer.
	 */
	wp_deregister_script('jquery');
	wp_register_script('jquery', get_theme_root_uri() . '/my/assets/js/jquery.min.js', false, false, true);
	wp_enqueue_script('jquery');

	/**
	 * Add custom scripts and styles.
	 */
	wp_enqueue_style('semantic-ui', get_theme_root_uri() . '/my/assets/css/semantic.min.css');
	wp_enqueue_style('style', get_theme_root_uri() . '/my/style.css', ['semantic-ui']);
	wp_enqueue_script('semantic-ui', get_theme_root_uri() . '/my/assets/js/semantic.min.js', false, false, true);

	if (is_front_page()) {
		wp_enqueue_script('tangular', get_theme_root_uri() . '/my/assets/js/tangular.min.js', false, false, true);
		wp_enqueue_script('calendar', get_theme_root_uri() . '/my/assets/js/calendar.min.js', ['jquery'], false, true);
		wp_enqueue_script('index', get_theme_root_uri() . '/my/assets/js/index.js', ['jquery'], false, true);
		wp_enqueue_style('calendar', get_theme_root_uri() . '/my/assets/css/calendar.min.css', ['semantic-ui']);
	} else {
		wp_enqueue_script('owl-init', get_theme_root_uri() . '/my/assets/js/owl-init.js', ['jquery'], false, true);
	}
}

add_action('wp_enqueue_scripts', 'my_theme_assets', 100);

/**
 * Remove dns-prefetch.
 */
remove_action('wp_head', 'wp_resource_hints', 2);

/**
 * Remove scripts and styles of emoji.
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/**
 * Remove meta generator.
 */
remove_action('wp_head', 'wp_generator');

/**
 * Remove Windows Live Writer link.
 */
remove_action('wp_head', 'wlwmanifest_link');

/**
 * Remove link for editing external services.
 */
remove_action('wp_head', 'rsd_link');

/**
 * Remove api.w.org.
 */
remove_action('wp_head', 'rest_output_link_wp_head', 10);

/**
 * Remove oembed.
 */
remove_action('wp_head', 'wp_oembed_add_discovery_links');

/**
 * Remove shortlink.
 */
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * Remove Feed Links.
 */
remove_action('wp_head', 'feed_links', 2);

/**
 * Remove parent theme title.
 */
remove_action('wp_head', '_wp_render_title_tag', 1);

/**
 * Remove prev, next page links.
 */
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

/**
 * Remove canonical link.
 */
remove_action('wp_head', 'rel_canonical');

/**
 * Get hierarchically list of taxonomy terms.
 * @param string $taxonomy Taxonomy name.
 * @param int $parent Parent element ID.
 * @return WP_Term[] Array of taxonomy objects.
 */
function get_taxonomy_hierarchy(string $taxonomy = '', int $parent = 0) {
	$terms = get_terms([
		'taxonomy'   => $taxonomy,
		'parent'     => $parent,
		'hide_empty' => false
	]);
	$children = [];
	foreach ($terms as $term) {
		$term->children = get_taxonomy_hierarchy(
			$taxonomy,
			$term->term_id
		);
		$children[$term->term_id] = $term;
	}

	return $children;
}

/**
 * Get list of genres.
 * @param bool $hierarchical
 * @param bool $raw If true then return posts unformatted (as is).
 * @return array|int|WP_Error|WP_Term[]
 */
function getGenres(bool $hierarchical = false, bool $raw = false) {
	$taxonomy = 'genre';

	if ($hierarchical) {
		$genres = get_taxonomy_hierarchy($taxonomy);
	} else {
		$genres = get_terms([
			'taxonomy'   => $taxonomy,
			'hide_empty' => false
		]);
	}

	if (!$raw && count($genres)) {
		$acceptor = [];
		foreach ($genres as $genre) {
			if ($hierarchical) {
				$items = [];
				foreach ($genre->children as $v) {
					$items[$v->term_id] = $v->name;
				}
				$acceptor[] = [
					$genre->term_id => $genre->name,
					'items' => $items
				];
			} else {
				$acceptor[$genre->term_id] = $genre->name;
			}
		}
		$genres = $acceptor;
	}

	return $genres;
}

/**
 * Get list of artists (id => name).
 * @param array $postIds Return only specific posts.
 * @param bool $raw If true then return posts unformatted (as is).
 * @return array|int[]|WP_Post[]
 */
function getArtists(array $postIds = [], bool $raw = false) {
	$args = [
		'post_type' => 'artist',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC'
	];
	if (count($postIds)) {
		$args['post__in'] = $postIds;
	}
	$artists = get_posts($args);
	if (!$raw && count($artists)) {
		$acceptor = [];
		foreach ($artists as $artist) {
			$acceptor[$artist->ID] = $artist->post_title;
		}
		$artists = $acceptor;
	}

	return $artists;
}

/**
 * Get tracklist from meta-data.
 * @param array $meta Meta fields.
 * @param bool $duration Return data with track duration.
 * @return array
 */
function getTracksFromMeta(array $meta = [], bool $duration = true) {
	$tracks = [];
	if (!empty($meta['tracklist'])) {
		$amount = (int)$meta['tracklist'][0];
		for ($i = 0; $i < $amount; $i++) {
			try {
				$tracks[] = [
					'name' => sanitize_text_field(
						$meta["tracklist_{$i}_track"][0]
					),
					'duration' => substr(
						$meta["tracklist_{$i}_length"][0], 3
					)
				];
			} catch (Throwable $t) {
				$tracks[] = [
					'name' => EMPTY_DATA_TEXT,
					'duration' => '00:00'
				];
			}
		}
	}

	return $tracks;
}

/**
 * Get songs of specific artist.
 * @param $id Artist ID.
 * @return array List of songs grouped by release name and sorted by date.
 */
function getArtistSongs(int $id) {
	$args = [
		'meta_key' => 'date',
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'meta_query' => [
			[
				'key' => 'author',
				'value' => "\"{$id}\"",
				'compare' => 'LIKE'
			]
		]
	];

	$data = [];
	if ($releases = getReleases(0, false, [], true, $args)) {
		foreach ($releases['items'] as $release) {
			$meta = get_post_meta($release->ID);
			$tracks = getTracksFromMeta($meta);
			$data[] = [
				'title' => esc_html($release->post_title),
				'tracks' => $tracks,
				'date' => $meta['date'][0]
			];
		}
	}

	return $data;
}

/**
 * Search value by key.
 * @param array $array Input array.
 * @param int $search Array's key.
 * @return bool|mixed
 */
function searchByKey(array $array, int $search) {
	$array = new RecursiveIteratorIterator(new RecursiveArrayIterator($array));
	foreach ($array as $key => $value) {
		if ($search === $key)
			return $value;
	}
	return false;
}

/**
 * Get all posts related to musical releases (Post Type = release).
 * @param int $page
 * @param bool $extra Include additional information.
 * @param array $postIds Return only specific posts.
 * @param bool $raw If true then return posts unformatted (as is).
 * @param array $in Additional query args.
 * @param string $sorting Sorting.
 * @param array $filtering Filtering.
 * @return array|int[]|WP_Post[]
 */
function getReleases(
	int   $page = 0,
	bool  $extra = true,
	array $postIds = [],
	bool  $raw = false,
	array $in = [],
	string $sorting = '',
	array $filtering = []
) {
	// Default params.
	$args = [
		'post_type' => 'release',
		'post_status' => 'publish',
		'posts_per_page' => -1
	];

	if (count($in)) {
		$args = array_merge($args, $in);
	}

	if (count($postIds)) {
		$args['post__in'] = $postIds;
	}

	if (!empty($sorting) && in_array($sorting, array_keys(getSortingOptions()))) {
		switch ($sorting) {
			case 'name':
				$args = array_merge($args, [
					'orderby' => 'post_title',
					'order' => 'ASC'
				]);
				break;
			case 'date':
				$args = array_merge($args, [
					'orderby' => 'post_date',
					'order' => 'DESC'
				]);
				break;
			case 'release-date':
				$args = array_merge($args, [
					'meta_key' => 'date',
					'orderby' => 'meta_value',
					'order' => 'DESC'
				]);
				break;
		}
	}

	if (count($filtering)) {
		$metaQuery = [
			'meta_query' => []
		];
		if (!empty($filtering['format']) &&
		    in_array($filtering['format'], getReleaseFormats())) {
			$metaQuery['meta_query'][] = [
				'key' => 'format',
				'value' => $filtering['format'],
				'compare' => '='
			];
		}
		if (!empty($filtering['country']) &&
		    ctype_alpha($filtering['country'])) {
			$metaQuery['meta_query'][] = [
				'key' => 'country',
				'value' => strtoupper($filtering['country']),
				'compare' => '='
			];
		}
		if (!empty($filtering['date-from']) || !empty($filtering['date-to'])) {
			$currentYear = date('Y');
			if (!is_numeric($filtering['date-from'])) {
				$filtering['date-from'] = $currentYear;
			}
			if (!is_numeric($filtering['date-to'])) {
				$filtering['date-to'] = $currentYear;
			}
			$metaQuery['meta_query'][] = [
				'key' => 'date',
				'value' => ["{$filtering['date-from']}-01-01", "{$filtering['date-to']}-12-31"],
				'compare' => 'BETWEEN',
				'type' => 'DATE'
			];
		}
		if (preg_match('/^\d+(,\d+)*$/', $filtering['genre'])) {
			$filtering['genre'] = is_numeric($filtering['genre']) ?
				[$filtering['genre']] : explode(',', $filtering['genre']);
			$acceptor = [];
			foreach ($filtering['genre'] as $genre) {
				$acceptor[] = [
					'key' => 'genre',
					'value' => "\"{$genre}\"",
					'compare' => 'LIKE'
				];
			}
			if (count($acceptor) > 1) {
				$metaQuery['meta_query'][] = array_merge(
					['relation' => 'OR'], $acceptor
				);
			} else {
				$metaQuery['meta_query'][] = $acceptor[0];
			}
		}
		if (count($metaQuery['meta_query'])) {
			if (count($metaQuery['meta_query']) > 1) {
				$metaQuery['meta_query']['relation'] = 'AND';
			}
			$args = array_merge($args, $metaQuery);
		}
	}

	$releases = get_posts($args);

	/**
	 * Total count of posts.
	 */
	$total = count($releases);

	/**
	 * Pages.
	 */
	$pages = ceil($total / RELEASES_PER_PAGE);

	if ($page > $pages) {
		$page = $pages;
	}

	/**
	 * Take only what we need (reduce data).
	 */
	if ($page) {
		$offset = ($page - 1) * RELEASES_PER_PAGE;
		$releases = array_slice($releases, $offset, RELEASES_PER_PAGE);
	}

	if (!$raw) {

		$artistsList = getArtists();
		$genresList  = getGenres(/* hierarchical = */ true);

		$data = [];
		foreach ($releases as $release) {
			/**
			 * Get release metadata (author, format, genre, etc.).
			 */
			$meta = get_post_meta($release->ID);

			/**
			 * Get release format.
			 */
			$format = empty($meta['format']) ?
				EMPTY_DATA_TEXT : esc_html($meta['format'][0]);

			/**
			 * Get release country.
			 */
			$country = empty($meta['country']) ?
				EMPTY_DATA_TEXT : $meta['country'][0];

			/**
			 * Get release date.
			 */
			$date = empty($meta['date']) ?
				EMPTY_DATA_TEXT : date('d.m.Y', strtotime($meta['date'][0]));

			/**
			 * Get release authors.
			 */
			try {
				if (!count($authors = unserialize($meta['author'][0]))) {
					throw new Exception('No information about the authors!');
				}
				$acceptor = [];
				foreach ($authors as $id) {
					$acceptor[] = [
						'name' => esc_html($artistsList[$id]),
						'page' => get_permalink($id)
					];
				}
				$authors = $acceptor;
			} catch (Throwable $t) {
				$authors = [[
					'name' => EMPTY_DATA_TEXT,
					'page' => '#'
				]];
			}

			/**
			 * Get release tracklist.
			 */
			$tracks = getTracksFromMeta($meta);

			/**
			 * Get release genre.
			 */
			try {
				if (!count($genres = unserialize($meta['genre'][0]))) {
					throw new Exception('No information about the genres!');
				}
				$genres = array_map(function($v) use ($genresList) {
					return searchByKey($genresList, (int)$v);
				}, $genres);
				$genres = esc_html(implode(', ', $genres));
			} catch (Throwable $t) {
				$genres = EMPTY_DATA_TEXT;
			}

			$data[] = [
				'id'      => $release->ID,
				'title'   => $release->post_title,
				'url'     => get_permalink($release->ID),
				'authors' => $authors,
				'genres'  => $genres,
				'format'  => $format,
				'country' => $country,
				'date'    => $date,
				'tracks'  => $tracks
			];
		}
		$releases = $data;
	}

	$releases = [
		'pagination' => ['page' => $page, 'total' => $total],
		'items' => $releases
	];

	if ($extra) {
		$releases['extra'] = [
			'artists' => $artistsList,
			'genres'  => $genresList
		];
	}

	return $releases;
}

/**
 * Get list of release available formats.
 */
function getReleaseFormats() {
	return [
		'Album'      => 'Album',
		'Collection' => 'Collection',
		'EP'         => 'EP',
		'Single'     => 'Single',
		'Remix'      => 'Remix'
	];
}

/**
 * Sorting variants.
 * @return array
 */
function getSortingOptions() {
	return [
		'name' => 'By Name',
		'date' => 'By Date',
		'release-date' => 'By Release Date'
	];
}

/**
 * Populate "format" field with predefined values.
 * @param array $field Field description.
 * @return array
 */
function populate_format_field(array $field) {
	// Set choices.
	$field['choices'] = getReleaseFormats();

	return $field;
}
add_filter('acf/load_field/name=format', 'populate_format_field');

/**
 * ajax-requests.
 */
if (wp_doing_ajax()) {
	add_action('wp_ajax_get_data', 'ajax_get_data');
	add_action('wp_ajax_nopriv_get_data', 'ajax_get_data');

	add_action('wp_ajax_add_release', 'ajax_add_release');
	add_action('wp_ajax_nopriv_add_release', 'ajax_add_release');
}

/**
 * Get release page.
 */
function ajax_get_data() {
	/**
	 * Check nonce identity.
	 */
	check_ajax_referer('releases', 'nonce');

	if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
		$response = [
			'status'  => 'success',
			'message' => getReleases(
				$_REQUEST['page'], false, [], false, [], $_REQUEST['sorting'],
				[
					'genre'     => $_REQUEST['filtering-genre'],
					'format'    => $_REQUEST['filtering-format'],
					'country'   => $_REQUEST['filtering-country'],
					'date-from' => $_REQUEST['filtering-date-from'],
					'date-to'   => $_REQUEST['filtering-date-to']
				]
			)
		];
	} else {
		$response = [
			'status'  => 'error',
			'message' => 'Invalid page parameter'
		];
	}

	echo json_encode($response);

	wp_die();
}

/**
 * Add new music release.
 */
function ajax_add_release() {
	/**
	 * Check nonce identity.
	 */
	check_ajax_referer('release', 'nonce');

	$response = [
		'status' => 'error'
	];

	/**
	 * Check input params.
	 */
	$fields = [
		'name',   'author',  'genre',
		'format', 'country', 'date',
		'tracklist'
	];

	try {
		foreach ($fields as $field) {
			if (empty($_REQUEST["release-{$field}"])) {
				throw new ErrorException("Missing required parameter: {$field}");
			}
			$$field = urldecode($_REQUEST["release-{$field}"]);
		}

		// String of numbers with comma as delimiter.
		$reNums = '/^\d+(,\d+)+$/';
		// Time (mm:ss).
		$reTime = '/^\d{2}:\d{2}$/';

		// Author.
		if (!is_numeric($author)) {
			if (!preg_match($reNums, $author)) {
				throw new ErrorException('Invalid parameter format (author)');
			}
			$author = explode(',', $author);
		} else {
			$author = [$author];
		}

		// Genre.
		if (!is_numeric($genre)) {
			if (!preg_match($reNums, $genre)) {
				throw new ErrorException('Invalid parameter format (genre)');
			}
			$genre = explode(',', $genre);
		} else {
			$genre = [$genre];
		}

		// Name.
		$name = sanitize_text_field($name);

		// Format.
		if (!in_array($format, getReleaseFormats())) {
			throw new ErrorException('Format value is out of range');
		}

		// Country.
		if (!ctype_alpha($country)) {
			throw new ErrorException('Invalid parameter format (country)');
		}
		$country = strtoupper($country);

		// Date.
		$date = date('Y-m-d', strtotime($date));

		// Tracklist.
		$tracklist = json_decode($tracklist, true);
		if (JSON_ERROR_NONE !== json_last_error()) {
			throw new ErrorException('Wrong tracklist structure');
		}
		foreach ($tracklist as &$item) {
			$item['track'] = sanitize_text_field($item['track']);
			if (!preg_match($reTime, $item['length'])) {
				// Wrong track length. Set default value.
				$item['length'] = '00:00';
			}
			$item['length'] = '00:' . $item['length'];
		}

		/**
		 * All params are correct. Create new post.
		 */
		$post_data = [
			'post_title'  => $name,
			'post_status' => 'publish',
			'post_type'   => 'release',
			'meta_input'  => [
				'author'  => $author,
				'genre'   => $genre,
				'format'  => $format,
				'country' => $country,
				'date'    => $date
			]
		];

		if (($id = wp_insert_post($post_data)) &&
		    update_field('tracklist', $tracklist, $id)) {
			// Post was successfully created. Return positive answer.
			$response['status'] = 'success';
		} else {
			throw new ErrorException('Could not create post');
		}
	} catch (Throwable $t) {
		$response['message'] = $t->getMessage();
	}

	echo json_encode($response);

	wp_die();
}

/**
 * Shortcodes.
 */

/**
 * Return list of last seen entities.
 * @param array $attrs Array of shortcode attributes.
 * @return string
 */
function last_seen(array $attrs = []) {
	/**
	 * Return empty string if mandatory param weren't passed to.
	 */
	if (empty($attrs['current'])) {
		return '';
	}

	$type = get_post_type($attrs['current']);

	// Not supported post type.
	if (empty($_SESSION['last_seen'][$type])) {
		return '';
	}

	$saved = $_SESSION['last_seen'][$type];

	// Remove current page from flow.
	if (($key = array_search($attrs['current'], $saved)) !== false) {
		unset($saved[$key]);
	}

	if (!count($saved)) {
		return '';
	}

	$items = $type === 'artist' ?
		getArtists($saved, true) : getReleases(0, false, $saved, true)['items'];

	if (!empty($items)) {
		$html = '
			<h2>Last Seen:</h2>
			<div class="last_seen owl-carousel owl-theme">';
		foreach ($items as $item) {
			$html .= '
				<a href="' . get_permalink($item->ID) . '" class="last_seen__item" target="_blank">
					<img class="last_seen__item-image" 
					     src="' . get_theme_root_uri() . '/my/assets/images/' . $type . '.png" 
					     alt="' . $item->post_title . '" />
					<div class="last_seen__item-text">
						<span class="ui green medium label">' . $item->post_title . '</span>
					</div>
				</a>';
		}
		$html .= '</div>';
	}

	return empty($html) ? '' : $html;
}
add_shortcode('last_seen', 'last_seen');

/**
 * Save page ID to storage.
 * @param int $id Post ID.
 */
function rememberPage(int $id = 0) {
	if (!$id) {
		return;
	}
	// Get post type.
	$type = get_post_type($id);
	if (!isset($_SESSION['last_seen'])) {
		$_SESSION['last_seen'] = [];
	}
	if (!isset($_SESSION['last_seen'][$type])) {
		$_SESSION['last_seen'][$type] = [];
	}
	if (!in_array($id, $_SESSION['last_seen'][$type])) {
		$_SESSION['last_seen'][$type][] = $id;
	}
}

/**
 * Session setup.
 */
add_action('init', 'init_session', 1);
add_action('wp_logout', 'stop_session');
add_action('wp_login', 'stop_session');

function init_session() {
	if (!session_id()) {
		session_start();
	}
}

function stop_session() {
	session_destroy();
}