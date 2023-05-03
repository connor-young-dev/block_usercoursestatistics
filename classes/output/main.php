<?php

namespace block_usercoursestatistics\output;

defined('MOODLE_INTERNAL') || die();

use renderable;
use renderer_base;
use templatable;

class main implements renderable, templatable {
    public function export_for_template(renderer_base $output) {
        $showenrolledcourses = get_config('block_usercoursestatistics', 'showenrolledcourses');
        $showcompletedcourses = get_config('block_usercoursestatistics', 'showcompletedcourses');
        $showinprogresscourses = get_config('block_usercoursestatistics', 'showinprogresscourses');
        $showbadges = get_config('block_usercoursestatistics', 'showbadges');
        $showcertificates = get_config('block_usercoursestatistics', 'showcoursecertificates');

        return [
            'showenrolledcourses' => $showenrolledcourses,
            'showinprogresscourses' => $showinprogresscourses,
            'showcompletedcourses' => $showcompletedcourses,
            'showbadges' => $showbadges,
            'showcertificates' => $showcertificates
        ];
    }
}

