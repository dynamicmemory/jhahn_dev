let buttonStarted = false;
let timeOutId = null;

window.onload = function start() {
    let startButton = document.getElementById("start_button");
    let resetButton = document.getElementById("reset_button");
    startButton.addEventListener("click", clicked);
    resetButton.addEventListener("click", reset_timer);
}

function clicked(e) {
    if (e.cancelable) e.preventDefault();
    
    if (!buttonStarted) {
        let state_date = new Date();
        calculate_time(state_date);
        buttonStarted = true;
    }
}

function calculate_time(start_date) {
    
    var timer_element = document.getElementById("timer");
    let current_time = new Date().getTime();
    let timer = current_time - start_date.getTime()
    
    let seconds = Math.floor(timer / 1000);
    let minutes = Math.floor(seconds / 60);
    let hours = Math.floor(minutes / 60);

    let secDisplay = seconds % 60;
    let minDisplay = minutes % 60;

    timer_element.innerHTML = `${hours}h: ${minDisplay}m: ${secDisplay}s`;

    timeOutId = setTimeout(() => calculate_time(start_date), 1000);
}

function reset_timer(e) {
    if (e.cancelable) e.preventDefault();
    
    let timer_element = document.getElementById("timer");
    timer_element.innerHTML = `0h: 0m: 0s`;
    buttonStarted = false;
    clearTimeout(timeOutId);

}
