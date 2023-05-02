<?php

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('block_usercoursestatistics/showenrolledcourses', get_string('showenrolledcourses', 'block_usercoursestatistics'), get_string('showenrolledcourses_desc', 'block_usercoursestatistics'), 1));

    $settings->add(new admin_setting_configcheckbox('block_usercoursestatistics/showcompletedcourses', get_string('showcompletedcourses', 'block_usercoursestatistics'), get_string('showcompletedcourses_desc', 'block_usercoursestatistics'), 1));

    $settings->add(new admin_setting_configcheckbox('block_usercoursestatistics/showinprogresscourses', get_string('showinprogresscourses', 'block_usercoursestatistics'), get_string('showinprogresscourses_desc', 'block_usercoursestatistics'), 1));

    $settings->add(new admin_setting_configcheckbox('block_usercoursestatistics/showbadges', get_string('showbadges', 'block_usercoursestatistics'), get_string('showbadges_desc', 'block_usercoursestatistics'), 1));

    $settings->add(new admin_setting_configcheckbox('block_usercoursestatistics/showcoursecertificates', get_string('showcoursecertificates', 'block_usercoursestatistics'), get_string('showcoursecertificates_desc', 'block_usercoursestatistics'), 0));
}