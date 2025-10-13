<?php

namespace App;

use Timber\Timber;

require_once __DIR__ . '/vendor/autoload.php';

Timber\Timber::init();

Timber::$dirname = array('templates', 'views');

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'menus' );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types() {

	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['foo']   = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menu']  = Timber::get_menu();
		$context['site']  = $this;
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );
	}

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter(new Twig_SimpleFilter('myfoo', array($this, 'myfoo')));
		return $twig;
	}

}

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'tailwind',
        get_template_directory_uri() . '/src/output.css',
        [],
        filemtime(get_template_directory() . '/src/output.css')
    );
});

add_filter('timber/cache/twig', '__return_false');

class StarterSite
{
    public function __construct()
    {
        add_filter('timber/context', [$this, 'add_to_context']);
        add_filter('timber/twig', [$this, 'add_to_twig']);
        add_filter('template_include', [$this, 'custom_templates']);
        add_action('init', [$this, 'register_case_study_cpt']);
    }

    public function add_to_context($context)
    {
        $context['site'] = [
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'url' => get_bloginfo('url'),
        ];

        $context['menu'] = Timber::get_menu();
        return $context;
    }

    public function add_to_twig($twig)
    {
        return $twig;
    }

    public function custom_templates($template)
    {
        if (is_front_page()) {
            return Timber::render('home.twig');
        }

        if (is_page('about')) {
            return Timber::render('about.twig');
        }

        if (is_page('contact')) {
            return Timber::render('contact.twig');
        }

        if (is_page()) {
            return Timber::render('page.twig');
        }

        if (is_post_type_archive('case_study')) {
            $context = Timber::context();
            $context['posts'] = Timber::get_posts([
                'post_type' => 'case_study',
                'posts_per_page' => -1,
            ]);

            return Timber::render('archive-case_study.twig', $context);
        }

        if (is_archive()) {
            return Timber::render('archive.twig');
        }

        return $template;
    }

    public function register_case_study_cpt()
    {
        register_post_type('case_study', [
            'labels' => [
                'name' => 'Case Studies',
                'singular_name' => 'Case Study',
                'add_new_item' => 'Add New Case Study',
                'edit_item' => 'Edit Case Study',
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => 'case-studies'],
            'show_in_rest' => true,
            'supports' => ['title', 'editor', 'thumbnail'],
            'menu_icon' => 'dashicons-portfolio',
        ]);
    }
}

new StarterSite();
