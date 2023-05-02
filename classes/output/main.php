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

        $enrolledcourses = $completedcourses = $inprogresscourses = $badges = $certificates = null;

        $showenrolledcourses = get_config('block_usercoursestatistics', 'showenrolledcourses');
        $showcompletedcourses = get_config('block_usercoursestatistics', 'showcompletedcourses');
        $showinprogresscourses = get_config('block_usercoursestatistics', 'showinprogresscourses');
        $showbadges = get_config('block_usercoursestatistics', 'showbadges');
        $showcertificates = get_config('block_usercoursestatistics', 'showcoursecertificates');

        if ($showenrolledcourses || $showcompletedcourses || $showinprogresscourses) {
            $courses = enrol_get_users_courses($USER->id);

            if (!empty($courses)) {
                $enrolledcourses = $showenrolledcourses ? count($courses) : null;

                if ($showcompletedcourses || $showinprogresscourses) {
                    $coursecompletions = block_usercoursestatistics_get_user_course_completions($USER->id, $courses);
                    $inprogresscourses = $showinprogresscourses ? $coursecompletions['inprogress'] : null;
                    $completedcourses = $showcompletedcourses ? $coursecompletions['completed'] : null;
                }
            }
        }

        $badges = $showbadges ? count(badges_get_user_badges($USER->id)) : null;
        $certificates = $showcertificates ? block_usercoursestatistics_get_course_certificates($USER->id) : null;

        return [
            'enrolledcourses' => $enrolledcourses,
            'showenrolledcourses' => $showenrolledcourses,
            'inprogresscourses' => $inprogresscourses,
            'showinprogresscourses' => $showinprogresscourses,
            'completedcourses' => $completedcourses,
            'showcompletedcourses' => $showcompletedcourses,
            'badges' => $badges,
            'showbadges' => $showbadges,
            'certificates' => $certificates,
            'showcertificates' => $showcertificates
        ];
    }
}

