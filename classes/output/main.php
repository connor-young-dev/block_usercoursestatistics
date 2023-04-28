<?php

namespace block_usercoursestatistics\output;

defined('MOODLE_INTERNAL') || die();

use renderable;
use renderer_base;
use templatable;
require_once(__DIR__ . '/../../lib.php');
require_once($CFG->libdir . '/badgeslib.php');

class main implements renderable, templatable {
    public function export_for_template(renderer_base $output) {
        global $USER;

        // Get the list of courses the user is enrolled on.
        $courses = enrol_get_users_courses($USER->id);
        $badges = count(badges_get_user_badges($USER->id));
        $enrolledcourses = count($courses);
        $coursecompletions = block_usercoursestatistics_get_user_course_completions($USER->id, $courses);
        $inprogresscourses = $coursecompletions['inprogress'];
        $completedcourses = $coursecompletions['completed'];
        $certificates = block_usercoursestatistics_get_course_certificates($USER->id);
        return [
            'enrolledcourses' => $enrolledcourses,
            'inprogresscourses' => $inprogresscourses,
            'completedcourses' => $completedcourses,
            'badges' => $badges,
            'certificates' => $certificates
        ];
    }
}

