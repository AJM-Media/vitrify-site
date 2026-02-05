<?php
/**
 * ACF field group registration for Vitrify theme.
 * Requires the Advanced Custom Fields plugin. Fields are available when ACF is active.
 */

if (!function_exists('acf_add_local_field_group')) {
    return;
}

/**
 * Register custom ACF location rule "Page Slug" so field groups can target pages by slug.
 * This allows About/Services/Contact groups to show when the page exists, even if it was
 * created after the theme was installed (unlike get_page_by_path() at init which fixes ID once).
 */
add_filter('acf/location/rule_types', 'vitrify_acf_location_rule_types');
function vitrify_acf_location_rule_types($rule_types) {
    if (!is_array($rule_types)) {
        return $rule_types;
    }
    $rule_types['Page Slug'] = 'page_slug';
    return $rule_types;
}

add_filter('acf/location/rule_match/page_slug', 'vitrify_acf_location_rule_match_page_slug', 10, 3);
function vitrify_acf_location_rule_match_page_slug($match, $rule, $options) {
    $options = is_array($options) ? $options : [];
    $rule = is_array($rule) ? $rule : [];
    $page_slug = isset($rule['value']) ? $rule['value'] : '';
    if ($page_slug === '') {
        return false;
    }
    $post = null;
    if (!empty($options['post_id'])) {
        $post = get_post($options['post_id']);
    } elseif (!empty($options['post'])) {
        $post = is_object($options['post']) ? $options['post'] : get_post($options['post']);
    } elseif (is_admin() && isset($GLOBALS['post']) && $GLOBALS['post'] instanceof WP_Post) {
        $post = $GLOBALS['post'];
    }
    $is_match = $post && $post->post_type === 'page' && $post->post_name === $page_slug;
    $operator = isset($rule['operator']) ? $rule['operator'] : '==';
    return $operator === '==' ? $is_match : !$is_match;
}

add_action('acf/init', 'vitrify_register_acf_options_page');
function vitrify_register_acf_options_page() {
    if (!function_exists('acf_add_options_page')) {
        return;
    }
    acf_add_options_page([
        'page_title' => __('Theme Options', 'vitrify'),
        'menu_title' => __('Theme Options', 'vitrify'),
        'menu_slug'  => 'theme-options',
        'capability' => 'edit_posts',
        'redirect'   => false,
    ]);
}

add_action('acf/init', 'vitrify_register_acf_field_groups');
function vitrify_register_acf_field_groups() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    // Theme Options (Hero / Home)
    acf_add_local_field_group([
        'key' => 'group_vitrify_theme_options',
        'title' => 'Theme Options (Hero)',
        'fields' => [
            [
                'key' => 'field_hero_badge_text',
                'label' => 'Hero badge text',
                'name' => 'hero_badge_text',
                'type' => 'text',
                'default_value' => 'Announcing our next round of funding.',
            ],
            [
                'key' => 'field_hero_badge_link',
                'label' => 'Hero badge link URL',
                'name' => 'hero_badge_link',
                'type' => 'url',
            ],
            [
                'key' => 'field_hero_headline',
                'label' => 'Hero headline',
                'name' => 'hero_headline',
                'type' => 'text',
                'default_value' => 'Data to enrich your online business.',
            ],
            [
                'key' => 'field_hero_subtext',
                'label' => 'Hero subtext',
                'name' => 'hero_subtext',
                'type' => 'textarea',
                'default_value' => 'Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat.',
            ],
            [
                'key' => 'field_hero_cta_primary_label',
                'label' => 'Primary CTA label',
                'name' => 'hero_cta_primary_label',
                'type' => 'text',
                'default_value' => 'Get started',
            ],
            [
                'key' => 'field_hero_cta_primary_url',
                'label' => 'Primary CTA URL',
                'name' => 'hero_cta_primary_url',
                'type' => 'url',
                'default_value' => '/contact',
            ],
            [
                'key' => 'field_hero_cta_secondary_label',
                'label' => 'Secondary CTA label',
                'name' => 'hero_cta_secondary_label',
                'type' => 'text',
                'default_value' => 'Learn more',
            ],
            [
                'key' => 'field_hero_cta_secondary_url',
                'label' => 'Secondary CTA URL',
                'name' => 'hero_cta_secondary_url',
                'type' => 'url',
                'default_value' => '/about',
            ],
        ],
        'location' => [[[
            'param' => 'options_page',
            'operator' => '==',
            'value' => 'theme-options',
        ]]],
    ]);

    // About page
    acf_add_local_field_group([
        'key' => 'group_vitrify_about',
        'title' => 'About Page Content',
        'fields' => [
            [
                'key' => 'field_about_intro_headline',
                'label' => 'Intro headline',
                'name' => 'about_intro_headline',
                'type' => 'text',
                'default_value' => 'About Vitrify',
            ],
            [
                'key' => 'field_about_intro_paragraph',
                'label' => 'Intro paragraph',
                'name' => 'about_intro_paragraph',
                'type' => 'textarea',
                'default_value' => "At Vitrify, we're a consultancy built for innovation. We empower bold brands through strategy, design, and development — blending logic with aesthetic to move fast and look great doing it.",
            ],
            [
                'key' => 'field_about_mission_headline',
                'label' => 'Mission headline',
                'name' => 'about_mission_headline',
                'type' => 'text',
                'default_value' => 'Our Mission',
            ],
            [
                'key' => 'field_about_mission_text',
                'label' => 'Mission text',
                'name' => 'about_mission_text',
                'type' => 'textarea',
                'default_value' => 'To transform visionary ideas into high-performing digital products through strategy-first thinking, collaboration, and design-led execution.',
            ],
            [
                'key' => 'field_about_stats',
                'label' => 'Stats',
                'name' => 'about_stats',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => 'Add stat',
                'sub_fields' => [
                    ['key' => 'field_about_stat_value', 'label' => 'Value', 'name' => 'value', 'type' => 'text'],
                    ['key' => 'field_about_stat_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text'],
                ],
            ],
            [
                'key' => 'field_about_values',
                'label' => 'Core values',
                'name' => 'about_values',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add value',
                'sub_fields' => [
                    ['key' => 'field_about_value_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                    ['key' => 'field_about_value_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea'],
                ],
            ],
            [
                'key' => 'field_about_partner_logos',
                'label' => 'Partner logos',
                'name' => 'about_partner_logos',
                'type' => 'gallery',
                'return_format' => 'array',
            ],
            [
                'key' => 'field_about_team',
                'label' => 'Team members',
                'name' => 'about_team',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add team member',
                'sub_fields' => [
                    ['key' => 'field_about_team_name', 'label' => 'Name', 'name' => 'name', 'type' => 'text'],
                    ['key' => 'field_about_team_role', 'label' => 'Role', 'name' => 'role', 'type' => 'text'],
                    ['key' => 'field_about_team_photo', 'label' => 'Photo', 'name' => 'photo', 'type' => 'image', 'return_format' => 'array'],
                ],
            ],
        ],
        'location' => [[[
            'param' => 'page_slug',
            'operator' => '==',
            'value' => 'about',
        ]]],
    ]);

    // Services page (repeater)
    acf_add_local_field_group([
        'key' => 'group_vitrify_services',
        'title' => 'Services',
        'fields' => [
            [
                'key' => 'field_services_repeater',
                'label' => 'Services',
                'name' => 'services',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add service',
                'sub_fields' => [
                    ['key' => 'field_service_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text'],
                    ['key' => 'field_service_description', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea'],
                    ['key' => 'field_service_icon', 'label' => 'Icon / image', 'name' => 'icon', 'type' => 'image', 'return_format' => 'array'],
                ],
            ],
        ],
        'location' => [[[
            'param' => 'page_slug',
            'operator' => '==',
            'value' => 'services',
        ]]],
    ]);

    // Contact page
    acf_add_local_field_group([
        'key' => 'group_vitrify_contact',
        'title' => 'Contact Details',
        'fields' => [
            [
                'key' => 'field_contact_address',
                'label' => 'Address',
                'name' => 'contact_address',
                'type' => 'textarea',
            ],
            [
                'key' => 'field_contact_email',
                'label' => 'Email',
                'name' => 'contact_email',
                'type' => 'email',
            ],
            [
                'key' => 'field_contact_phone',
                'label' => 'Phone',
                'name' => 'contact_phone',
                'type' => 'text',
            ],
        ],
        'location' => [[[
            'param' => 'page_slug',
            'operator' => '==',
            'value' => 'contact',
        ]]],
    ]);

    // Case Study CPT (extend existing: client_name, project_duration, services_provided, external_url)
    acf_add_local_field_group([
        'key' => 'group_vitrify_case_study',
        'title' => 'Case Study Details',
        'fields' => [
            [
                'key' => 'field_case_study_client_name',
                'label' => 'Client name',
                'name' => 'client_name',
                'type' => 'text',
            ],
            [
                'key' => 'field_case_study_project_duration',
                'label' => 'Project duration',
                'name' => 'project_duration',
                'type' => 'text',
            ],
            [
                'key' => 'field_case_study_services_provided',
                'label' => 'Services provided (comma-separated)',
                'name' => 'services_provided',
                'type' => 'text',
            ],
            [
                'key' => 'field_case_study_external_url',
                'label' => 'External / project URL',
                'name' => 'external_url',
                'type' => 'url',
            ],
        ],
        'location' => [[[
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'case_study',
        ]]],
    ]);
}
