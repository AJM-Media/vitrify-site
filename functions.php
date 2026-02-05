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

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'tailwind',
        get_template_directory_uri() . '/src/output.css',
        [],
        filemtime(get_template_directory() . '/src/output.css')
    );
});

add_filter('timber/cache/twig', '__return_false');

if (file_exists(get_template_directory() . '/inc/acf-fields.php')) {
    require_once get_template_directory() . '/inc/acf-fields.php';
}

class StarterSite
{
    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'theme_supports']);
        add_action('init', [$this, 'register_menus']);
        add_action('init', [$this, 'register_case_study_cpt']);
        add_filter('timber/context', [$this, 'add_to_context']);
        add_filter('timber/twig', [$this, 'add_to_twig']);
        add_filter('template_include', [$this, 'custom_templates']);
    }

    public function theme_supports()
    {
        add_theme_support('automatic-feed-links');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support(
            'html5',
            array(
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            )
        );
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
        add_theme_support('menus');
    }

    public function register_menus()
    {
        register_nav_menus([
            'primary' => __('Primary Menu', 'vitrify'),
        ]);
    }

    public function add_to_context($context)
    {
        $context['site'] = [
            'name' => get_bloginfo('name'),
            'description' => get_bloginfo('description'),
            'url' => get_bloginfo('url'),
            'theme_link' => get_template_directory_uri(),
            'language_attributes' => get_language_attributes(),
        ];

        $context['menu'] = Timber::get_menu('primary');

        // Prev/next case studies on single case study
        if (is_singular('case_study') && isset($context['post'])) {
            $current = $context['post'];
            $context['prev_case_study'] = Timber::get_posts([
                'post_type' => 'case_study',
                'posts_per_page' => 1,
                'orderby' => 'date',
                'order' => 'DESC',
                'post__not_in' => [$current->id],
                'date_query' => [['before' => $current->date('Y-m-d H:i:s')]],
            ])[0] ?? null;
            $context['next_case_study'] = Timber::get_posts([
                'post_type' => 'case_study',
                'posts_per_page' => 1,
                'orderby' => 'date',
                'order' => 'ASC',
                'post__not_in' => [$current->id],
                'date_query' => [['after' => $current->date('Y-m-d H:i:s')]],
            ])[0] ?? null;
        }

        // Hero options (Theme Options) for home template
        $site_url = get_bloginfo('url');
        if (function_exists('get_field')) {
            $ctx_hero = [
                'badge_text' => get_field('hero_badge_text', 'option') ?: 'Announcing our next round of funding.',
                'badge_link' => get_field('hero_badge_link', 'option') ?: '#',
                'headline' => get_field('hero_headline', 'option') ?: 'Data to enrich your online business.',
                'subtext' => get_field('hero_subtext', 'option') ?: 'Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat.',
                'cta_primary_label' => get_field('hero_cta_primary_label', 'option') ?: 'Get started',
                'cta_primary_url' => get_field('hero_cta_primary_url', 'option') ?: '/contact',
                'cta_secondary_label' => get_field('hero_cta_secondary_label', 'option') ?: 'Learn more',
                'cta_secondary_url' => get_field('hero_cta_secondary_url', 'option') ?: '/about',
            ];
        } else {
            $ctx_hero = [
                'badge_text' => 'Announcing our next round of funding.',
                'badge_link' => '#',
                'headline' => 'Data to enrich your online business.',
                'subtext' => 'Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat.',
                'cta_primary_label' => 'Get started',
                'cta_primary_url' => '/contact',
                'cta_secondary_label' => 'Learn more',
                'cta_secondary_url' => '/about',
            ];
        }
        $ctx_hero['cta_primary_url_full'] = (strpos($ctx_hero['cta_primary_url'], 'http') === 0) ? $ctx_hero['cta_primary_url'] : rtrim($site_url, '/') . (strpos($ctx_hero['cta_primary_url'], '/') === 0 ? '' : '/') . $ctx_hero['cta_primary_url'];
        $ctx_hero['cta_secondary_url_full'] = (strpos($ctx_hero['cta_secondary_url'], 'http') === 0) ? $ctx_hero['cta_secondary_url'] : rtrim($site_url, '/') . (strpos($ctx_hero['cta_secondary_url'], '/') === 0 ? '' : '/') . $ctx_hero['cta_secondary_url'];
        $context['hero'] = $ctx_hero;

        return $context;
    }

    public function add_to_twig($twig)
    {
        return $twig;
    }

    public function custom_templates($template)
    {
        if (is_front_page()) {
            return get_template_directory() . '/front-page.php';
        }

        if (is_page('about')) {
            $context = Timber::context();
            return Timber::render('about.twig', $context);
        }

        if (is_page('contact')) {
            $context = Timber::context();
            return Timber::render('contact.twig', $context);
        }

        if (is_page('services')) {
            $context = Timber::context();
            return Timber::render('services.twig', $context);
        }

        if (is_page()) {
            $context = Timber::context();
            return Timber::render('page.twig', $context);
        }

        if (is_post_type_archive('case_study')) {
            $context = Timber::context();
            $context['posts'] = Timber::get_posts([
                'post_type' => 'case_study',
                'posts_per_page' => -1,
            ]);
            return Timber::render('archive-case_study.twig', $context);
        }

        if (is_home()) {
            return get_template_directory() . '/home.php';
        }

        if (is_archive()) {
            $context = Timber::context();
            return Timber::render('templates/archive.twig', $context);
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
