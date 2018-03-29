/* @author Dominic */
const FRAMES_PER_SECOND = 20;
const FRAME_PAUSE_TIME_IN_MS = 5000;
const ANIMATION_SPEED = parseInt(0.5 * FRAME_PAUSE_TIME_IN_MS);

$(document).ready(function(){
    // For each scrollable
    $('.scrollable').each(function(){
        // Cache variables
        var $this = $(this);
        var scrollHeight = $this[0].scrollHeight;
        // Return if scrolling is not needed.
        if (scrollHeight <= $this.height()) return;
        // Calculate scroll distance
        $this.scrollDistance = scrollHeight - $this.height();
        // Set timer
        window.setInterval(function(){
            var target = $this.scrollTop() == 0 ? $this.scrollDistance : 0;


            $this.animate({scrollTop : target}, ANIMATION_SPEED);
        }, FRAME_PAUSE_TIME_IN_MS);
    });
});