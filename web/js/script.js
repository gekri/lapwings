/* Set-up the slider */

$(document).ready(function() {
    $("#slide-wrapper").tabslet({
        mouseevent: "click", // Select tab on click or on hover - options: click, hover
        attribute: "href", // Use href or alt attribute to select tabs - options: href, alt
        animation: true, // Enables javascript animation effect on tabs change - options: false, true
        autorotate: false, // Enables automatic rotation of the tabs - options: false, true
        pauseonhover: true, // Stops autorotation as long as the mouse is over the tabs - options: false, true
        delay: 8000, // Sets the delay on automatic rotation - options: number in ms
        active: 1, // Select which tab will be visible at the beginning
        controls: {} // Set previous and next element - options: element class
    });
});
