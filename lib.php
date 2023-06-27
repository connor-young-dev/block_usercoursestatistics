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

function block_usercoursestatistics_get_user_session_time($userid) {
    global $DB;

    // Get the user's current login timestamp from the Moodle database.
    $user = $DB->get_record('user', ['id' => $userid], 'currentlogin');

    if ($user && $user->currentlogin) {
        // Calculate the duration of the current session.
        $startTime = $user->currentlogin;
        $endTime = time();
        $duration = $endTime - $startTime;

        $formattedSessionTime = gmdate("H:i:s", $duration);

        // Get the course access records for the current session.
        $courseAccessRecords = $DB->get_records_select('logstore_standard_log', "userid = :userid AND courseid > 1 AND action = 'viewed' AND timecreated > :starttime AND timecreated < :endtime GROUP BY courseid", [
            'userid' => $userid,
            'starttime' => $startTime,
            'endtime' => $endTime
        ]);

        // Calculate the total time spent in all courses during the session.
        $totalCourseTime = 0;

        foreach ($courseAccessRecords as $access) {
            $accessDuration = $access->timecreated - $startTime;
            $totalCourseTime += $accessDuration;
        }

        // Convert the total course time to "HH:MM:SS" format.
        $formattedCourseTime = gmdate("H:i:s", $totalCourseTime);

        return [
            'sessiontime' => $formattedSessionTime,
            'coursetime' => $formattedCourseTime
        ];
    }

    // Return default values if user session not found.
    return [
        'sessiontime' => '00:00:00',
        'coursetime' => '00:00:00'
    ];
}