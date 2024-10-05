$(document).ready(function() {
    var width = screen.width - 100;
    var height = screen.height - 200;

    // Generate a random alphabet between A-Z
    function randomAlphabet() {
        let randomCode = Math.floor(Math.random() * (90 - 65 + 1)) + 65;
        return String.fromCharCode(randomCode);
    }

    // Generate a random color
    function randomColor() {
        return '#' + Math.floor(Math.random() * 16777215).toString(16);
    }

    // Create and add a bubble
    function createBubble(x, y, letter) {
        let bubble = $('<div class="bubble"></div>').text(letter);
        bubble.css({
            'background-color': randomColor(),
            'top': y + 'px',
            'left': x + 'px'
        });
        $('#game-area').append(bubble);

        // Remove bubble on click and generate new random bubbles
        bubble.click(function() {
            $(this).remove();
            for (let i = 0; i < 3; i++) {
                createBubble(Math.random() * width, Math.random() * height, randomAlphabet());
            }
        });
    }

    // Create random bubble on keypress
    $(document).keypress(function(event) {
        if (event.which >= 65 && event.which <= 90) {  // A-Z
            let x = Math.random() * width;
            let y = Math.random() * height;
            let letter = String.fromCharCode(event.which);
            createBubble(x, y, letter);
        }
    });
});
