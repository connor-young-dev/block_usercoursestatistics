<?php

namespace block_usercoursestatistics\output;
defined('MOODLE_INTERNAL') || die();

require_once(__DIR__ . '/../../lib.php');
use renderable;
use renderer_base;
use templatable;

class main implements renderable, templatable {
    public function export_for_template(renderer_base $output) {
        global $USER;

        // Get the list of courses the user is enrolled on.
        $courses = enrol_get_users_courses($USER->id);
        $enrolledcourses = block_usercoursestatistics_enrolled_courses($courses);
        $coursecompletions = block_usercoursestatistics_get_user_courses_completion($courses, $USER->id);
        return [
            'enrolledcourses' => $enrolledcourses,
            'coursecompletions' => $coursecompletions
        ];
    }
}
