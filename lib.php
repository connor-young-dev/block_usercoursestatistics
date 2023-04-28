<?php
function block_usercoursestatistics_enrolled_courses($courses) {
    // Count the number of courses.
    $numcourses = count($courses);

    return $numcourses;
}

function block_usercoursestatistics_get_user_courses_completion(array $courses, int $userid) {
    global $DB, $CFG;
    require_once($CFG->libdir . '/completionlib.php');

    $courseids = array_map(function($course) {
        return $course->id;
    }, $courses);

    if (empty($courseids)) {
        return [];
    }

    [$insql, $inparams] = $DB->get_in_or_equal($courseids, SQL_PARAMS_NAMED, 'cid');

    $sql = "
        SELECT course, timecompleted
            FROM {course_completions}
            WHERE course $insql AND userid = :userid
    ";
    $params = $inparams + ['userid' => $userid];
    $completions = $DB->get_records_sql($sql, $params);
    $coursecompletions = [];
    foreach ($courses as $course) {
        $completion = new completion_info($course);
        $coursecompletions[$course->id] = (object) [
            'timecompleted' => $completions[$course->id]->timecompleted ?? null,
            'completionenabled' => $completion->is_enabled(),
        ];
    }

    $numcompletedcourses = count(array_filter($coursecompletions, function($completion) {
        return !is_null($completion->timecompleted);
    }));

    return $numcompletedcourses;
}