<?php

use \core_completion\progress;
use \core_competency\plan;

function block_usercoursestatistics_get_user_course_completions($userid, $courses) {
    $completedcount = 0;
    $inprogresscount = 0;

    foreach ($courses as $course) {
        $progress = progress::get_course_progress_percentage($course, $userid);
        if (isset($progress) && $progress < 100) {
            $inprogresscount++;
        }
        if ($progress === 100) {
            $completedcount++;
        }
    }

    return [
        'completed' => $completedcount,
        'inprogress' => $inprogresscount
    ];
}

function block_usercoursestatistics_get_course_certificates($userid) {
    global $DB;

    $certificateplugin = $DB->get_record('modules', ['name' => 'coursecertificate']);

    if (empty($certificateplugin)) {
        return;
    }

    $certificatecount = $DB->count_records_sql("
                SELECT COUNT(c.id)
                FROM {course_modules} cm
                JOIN {course_modules_completion} cmc ON cmc.coursemoduleid = cm.id
                JOIN {coursecertificate} c ON c.id = cm.instance
                WHERE cm.module = :moduleid AND cmc.userid = :userid AND cmc.completionstate = :state",
        ['moduleid' => $certificateplugin->id, 'userid' => $userid, 'state' => COMPLETION_COMPLETE]
    );

    return $certificatecount;
}

function block_usercoursestatistics_get_learning_plans($userid) {
    global $DB;

    $sql = "SELECT COUNT(id)
            FROM {competency_plan}
            WHERE userid = :userid
            AND status = :status";

    $params = [
        'userid' => $userid,
        'status' => plan::STATUS_COMPLETE
    ];

    $completedplanscount = $DB->count_records_sql($sql, $params);

    // Get the count of all learning plans for the user
    $allplanscount = $DB->count_records('competency_plan', ['userid' => $userid]);

    // Return an array with the count of all plans and completed plans
    return [
        'allplanscount' => $allplanscount,
        'completedplanscount' => $completedplanscount
    ];
}
