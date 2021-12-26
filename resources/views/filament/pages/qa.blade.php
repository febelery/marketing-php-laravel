<style>
    body {
        font-weight: 600;
        font-size: 40px;
    }

    .text {
        position: absolute;
        width: 80%;
        left: 25%;
        height: 40px;
        top: 30%;
        margin-top: -20px;
    }

    p {
        display: inline-block;
        vertical-align: top;
        margin: 0;
    }

    .word {
        position: absolute;
        width: 100%;
        opacity: 0;
    }

    .letter {
        display: inline-block;
        position: relative;
        float: left;
        transform: translateZ(25px);
        transform-origin: 50% 50% 25px;
    }

    .letter.out {
        transform: rotateX(90deg);
        transition: transform 0.32s cubic-bezier(0.55, 0.055, 0.675, 0.19);
    }

    .letter.behind {
        transform: rotateX(-90deg);
    }

    .letter.in {
        transform: rotateX(0deg);
        transition: transform 0.38s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .wisteria {
        color: #8e44ad;
    }

    .belize {
        color: #2980b9;
    }

    .pomegranate {
        color: #c0392b;
    }

    .green {
        color: #16a085;
    }

    .midnight {
        color: #6091c1;
    }

</style>

<x-filament::page>

    <div class="text">
        <p>页面建设中  </p>
        <p>
            <span class="word wisteria">愿薪火相传,美德不灭</span>
            <span class="word belize">只要不失去你的崇高,整个世界都会为你敞开</span>
            <span class="word pomegranate">天动万象，山海化形，荒地生星，璨如烈阳</span>
            <span class="word green">人间归离复归离，借一浮生逃浮生</span>
            <span class="word midnight">总有地上的生灵,敢于面对雷霆的威光</span>
        </p>
    </div>


</x-filament::page>

<script>
    var words = document.getElementsByClassName('word');
    var wordArray = [];
    var currentWord = 0;

    words[currentWord].style.opacity = 1;
    for (var i = 0; i < words.length; i++) {
        splitLetters(words[i]);
    }

    function changeWord() {
        var cw = wordArray[currentWord];
        var nw = currentWord == words.length-1 ? wordArray[0] : wordArray[currentWord+1];
        for (var i = 0; i < cw.length; i++) {
            animateLetterOut(cw, i);
        }

        for (var i = 0; i < nw.length; i++) {
            nw[i].className = 'letter behind';
            nw[0].parentElement.style.opacity = 1;
            animateLetterIn(nw, i);
        }

        currentWord = (currentWord == wordArray.length-1) ? 0 : currentWord+1;
    }

    function animateLetterOut(cw, i) {
        setTimeout(function() {
            cw[i].className = 'letter out';
        }, i*80);
    }

    function animateLetterIn(nw, i) {
        setTimeout(function() {
            nw[i].className = 'letter in';
        }, 340+(i*80));
    }

    function splitLetters(word) {
        var content = word.innerHTML;
        word.innerHTML = '';
        var letters = [];
        for (var i = 0; i < content.length; i++) {
            var letter = document.createElement('span');
            letter.className = 'letter';
            letter.innerHTML = content.charAt(i);
            word.appendChild(letter);
            letters.push(letter);
        }

        wordArray.push(letters);
    }

    changeWord();
    setInterval(changeWord, 4000);


</script>
