// Start the interval to update the timer every second
let interval;

// Function to update the timer
function updateTimer() {
    let currentTime = document.getElementById('active-time').textContent;
    let [hours, minutes, seconds] = currentTime.split(':').map(Number);

    // Increment the seconds
    seconds++;

    // Increment minutes and hours if necessary
    if (seconds >= 60) {
        seconds = 0;
        minutes++;
        if (minutes >= 60) {
            minutes = 0;
            hours++;
        }
    }

    // Format the updated time
    const updatedTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

    // Update the timer element
    document.getElementById('active-time').textContent = updatedTime;
}

// Initialize the timer
export const init = () => {

    // Start the interval to update the timer every second
    interval = setInterval(updateTimer, 1000);
};
