<?php

defined('MOODLE_INTERNAL') || die();

$capabilities = array(

    'block/usercoursestatistics:myaddinstance' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'user' => CAP_ALLOW
        ),

        'clonepermissionsfrom' => 'moodle/my:manageblocks'
    )
);
