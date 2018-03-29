/* @author Dominic */
const FRAMES_PER_SECOND = 20;
const FRAME_PAUSE_TIME_IN_MS = 5000;

$(document).ready(function(){
    // For each scrollable
    $('.scrollable').each(function(){
        // Cache this
        $this = $(this);
        // Calculate scroll distance
        $this.scrollDistance = $this[0].scrollHeight - $this.height();
        // Set timer
        window.setInterval(function(){
            var target = $this.scrollTop() == 0 ? $this.scrollDistance : 0;
            $this.animate({scrollTop : target}, 1000);
        }, FRAME_PAUSE_TIME_IN_MS);
    });
});