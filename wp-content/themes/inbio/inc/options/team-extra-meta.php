<?php
if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_5e8e345b7998e',
        'title' => 'Team Options',
        'fields' => array(
            array(
                'key' => 'field_5e8e346373580',
                'label' => 'Designation',
                'name' => 'team_designation',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => 'Developer',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'team_social_icons_field_5e4b96f6dc7f8',
                'label' => 'Add Social Network',
                'name' => 'rainbow_team_social_icons',
                'type' => 'repeater',
                'instructions' => 'Choose your icon markup here: https://fontawesome.com/icons',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'collapsed' => 'field_5e4bbd75dc7fa',
                'min' => 0,
                'max' => 0,
                'layout' => 'table',
                'button_label' => 'Add New Network',
                'sub_fields' => array(
                    array(
                        'key' => 'team_enter_social_icon_markup_field_5e4bbcaddc7f9',
                        'label' => 'Enter Social Icon Markup',
                        'name' => 'team_enter_social_icon_markup',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '<i class="fab fa-facebook-f"></i>',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'team_enter_social_icon_link_field_5e4bbd75dc7fa',
                        'label' => 'Enter Social Icon Link',
                        'name' => 'team_enter_social_icon_link',
                        'type' => 'url',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'rainbow_team',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ));

endif;