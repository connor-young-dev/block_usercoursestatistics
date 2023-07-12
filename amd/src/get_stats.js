export const init = () => {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', M.cfg.wwwroot + '/blocks/usercoursestatistics/get_stats.php', true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            // Successful response from server.
            const response = JSON.parse(xhr.responseText);

            // Update template with response data.
            if (response.showenrolledcourses == 1) {
                document.getElementById('enrolled-courses-count').textContent = response.enrolledcourses;
            }
            if (response.showinprogresscourses == 1) {
                document.getElementById('inprogress-courses-count').textContent = response.inprogresscourses;
            }
            if (response.showcompletedcourses == 1) {
                document.getElementById('completed-courses-count').textContent = response.completedcourses;
            }
            if (response.showbadges == 1) {
                document.getElementById('badges-count').textContent = response.badges;
            }
            if (response.showcertificates == 1) {
                document.getElementById('certificates-count').textContent = response.certificates;
            }
            if (response.showlearningplans == 1) {
                document.getElementById('learning-plans').textContent = response.learningplans;
            }
            if (response.showcompletedlearningplans == 1) {
                document.getElementById('completed-learning-plans').textContent = response.completedlearningplans;
            }
            document.getElementById('active-time').textContent = response.activetime;
            document.getElementById('last-course-completed').textContent = response.lastcoursecompleted;
        } else {
            // Error handling.
            console.log('Error:', xhr.statusText);
        }
    };

    xhr.onerror = function() {
        // Error handling.
        console.log('Error:', xhr.statusText);
    };

    xhr.send();
};