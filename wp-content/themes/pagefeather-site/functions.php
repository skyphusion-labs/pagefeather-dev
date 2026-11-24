<?php
/**
 * Pagefeather marketing theme.
 *
 * @package Pagefeather_Site
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
	exit;
}

add_action('after_setup_theme', static function (): void {
	add_theme_support('title-tag');
	add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');
});

/**
 * Keep the public marketing site indexable.
 *
 * When blog_public is 0, WordPress asks crawlers to skip the site.
 * This product site must stay public.
 */
function pagefeather_force_blog_public(): string
{
	return '1';
}
add_filter('pre_option_blog_public', 'pagefeather_force_blog_public');

add_action('after_setup_theme', static function (): void {
	global $wpdb;
	if (!isset($wpdb) || !is_object($wpdb)) {
		return;
	}
	$stored = $wpdb->get_var(
		"SELECT option_value FROM {$wpdb->options} WHERE option_name = 'blog_public' LIMIT 1"
	);
	if ((string) $stored === '1') {
		return;
	}
	// Drop the filter so update_option sees the real stored value.
	remove_filter('pre_option_blog_public', 'pagefeather_force_blog_public');
	update_option('blog_public', '1');
	add_filter('pre_option_blog_public', 'pagefeather_force_blog_public');
}, 1);

/**
 * Serve /llms.txt from the theme file.
 */
add_action('template_redirect', static function (): void {
	$path = wp_parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
	if (!is_string($path)) {
		return;
	}
	$path = untrailingslashit($path);
	if ($path !== '/llms.txt') {
		return;
	}
	$file = get_template_directory() . '/llms.txt';
	if (!is_readable($file)) {
		status_header(404);
		nocache_headers();
		exit;
	}
	status_header(200);
	header('Content-Type: text/plain; charset=utf-8');
	header('X-Robots-Tag: all');
	header('Cache-Control: public, max-age=3600');
	// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_readfile -- plain static theme file.
	readfile($file);
	exit;
}, 0);

add_action('wp_enqueue_scripts', static function (): void {
	$uri = get_template_directory_uri();
	$path = get_template_directory();
	$fonts_ver = (string) filemtime($path . '/assets/css/fonts.css');
	$css_ver = (string) filemtime($path . '/assets/css/site.css');
	$js_ver = (string) filemtime($path . '/assets/js/site.js');

	wp_enqueue_style('pagefeather-fonts', $uri . '/assets/css/fonts.css', [], $fonts_ver);
	wp_enqueue_style('pagefeather-site', $uri . '/assets/css/site.css', ['pagefeather-fonts'], $css_ver);
	wp_enqueue_script('pagefeather-site', $uri . '/assets/js/site.js', [], $js_ver, true);
}, 20);

// Preload display fonts for the first viewport. Register on wp_head directly
// (not from inside wp_enqueue_scripts): that hook runs after wp_head has started.
add_action('wp_head', static function (): void {
	$uri = get_template_directory_uri();
	$faces = [
		'dm-sans.woff2',
		'instrument-serif.woff2',
		'instrument-serif-italic.woff2',
		'jetbrains-mono.woff2',
	];
	foreach ($faces as $face) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url($uri . '/assets/fonts/' . $face)
		);
	}
}, 0);

add_filter('document_title_parts', static function (array $parts): array {
	if (is_front_page()) {
		$parts['title'] = 'Pagefeather';
		$parts['tagline'] = 'WordPress and WooCommerce on your Cloudflare account';
	}
	return $parts;
});

/**
 * Current path helper for nav active state.
 */
function pagefeather_current_path(): string
{
	$path = wp_parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
	$path = is_string($path) ? untrailingslashit($path) : '';
	return $path === '' ? '/' : $path . '/';
}

/**
 * Nav items for the marketing site.
 *
 * @return list<array{label:string,href:string,accent?:bool}>
 */
function pagefeather_nav_items(): array
{
	return [
		['label' => 'How it works', 'href' => '/how-it-works/'],
		['label' => 'Limits', 'href' => '/limits/'],
		['label' => 'Get started', 'href' => '/get-started/'],
		['label' => 'Evidence', 'href' => '/evidence/'],
		['label' => 'About', 'href' => '/about/'],
		['label' => 'GitHub', 'href' => 'https://github.com/skyphusion-labs/pagefeather', 'accent' => true],
	];
}
