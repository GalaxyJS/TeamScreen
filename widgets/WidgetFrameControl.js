/* @author Dominic */
const FRAMES_PER_SECOND = 20;
const FRAME_PAUSE_TIME_IN_MS = 5000;
const ANIMATION_SPEED = parseInt(0.5 * FRAME_PAUSE_TIME_IN_MS);

$(document).ready(function(){
    // Cache scrollables
    var $scrollables = $('.scrollable');

    // Caculate scrolling distances
    $scrollables.each(function() {
        // Cache variables
        var $this = $(this);
        var scrollHeight = $this[0].scrollHeight;
        // Return if scrolling is not needed.
        if (scrollHeight <= $this.height()) return;
        // Calculate scroll distance
        $this.data('scrollDistance', scrollHeight - $this.height());
    });

    function draw(){
        $scrollables.each(function(){
            var $this = $(this);
            var target = $this.scrollTop() == 0 ? $this.data('scrollDistance') : 0;
            $this.animate({scrollTop : target}, ANIMATION_SPEED);
        });
    }

    // Set loop
    window.setInterval(function(){
        draw();
    }, FRAME_PAUSE_TIME_IN_MS);
});