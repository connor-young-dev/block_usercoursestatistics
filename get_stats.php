<?php

define('AJAX_SCRIPT', true);

require_once('../../config.php');
require_once(__DIR__ . '/lib.php');
require_once($CFG->libdir . '/badgeslib.php');

global $USER;

$user_id = $USER->id;

// Set up response array.
$response = [
    'enrolledcourses' => null,
    'inprogresscourses' => null,
    'completedcourses' => null,
    'badges' => null,
    'certificates' => null,
    'showenrolledcourses' => null,
    'showinprogresscourses' => null,
    'showcompletedcourses' => null,
    'showbadges' => null,
    'showcertificates' => null
];

// Get user course statistics.
$enrolledcourses = $completedcourses = $inprogresscourses = $badges = $certificates = null;

$showenrolledcourses = get_config('block_usercoursestatistics', 'showenrolledcourses');
$showcompletedcourses = get_config('block_usercoursestatistics', 'showcompletedcourses');
$showinprogresscourses = get_config('block_usercoursestatistics', 'showinprogresscourses');
$showbadges = get_config('block_usercoursestatistics', 'showbadges');
$showcertificates = get_config('block_usercoursestatistics', 'showcoursecertificates');

if ($showenrolledcourses || $showcompletedcourses || $showinprogresscourses) {
    $courses = enrol_get_users_courses($user_id);

    if (!empty($courses)) {
        $enrolledcourses = $showenrolledcourses ? count($courses) : null;

        if ($showcompletedcourses || $showinprogresscourses) {
            $coursecompletions = block_usercoursestatistics_get_user_course_completions($user_id, $courses);
            $inprogresscourses = $showinprogresscourses ? $coursecompletions['inprogress'] : null;
            $completedcourses = $showcompletedcourses ? $coursecompletions['completed'] : null;
        }
    }
}

$badges = $showbadges ? count(badges_get_user_badges($user_id)) : null;
$certificates = $showcertificates ? block_usercoursestatistics_get_course_certificates($user_id) : null;

// Populate response array.
$response['enrolledcourses'] = $enrolledcourses;
$response['inprogresscourses'] = $inprogresscourses;
$response['completedcourses'] = $completedcourses;
$response['badges'] = $badges;
$response['certificates'] = $certificates;
$response['showenrolledcourses'] = $showenrolledcourses;
$response['showinprogresscourses'] = $showinprogresscourses;
$response['showcompletedcourses'] = $showcompletedcourses;
$response['showbadges'] = $showbadges;
$response['showcertificates'] = $showcertificates;

// Send response.
header('Content-Type: application/json');
echo json_encode($response);
exit;

