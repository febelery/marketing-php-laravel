<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>夕阳下的奔跑</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            color: #DDDDDD;
            font: 16px/2 Tahoma, 'Microsoft YaHei', sans-serif;
            background: #424242;
        }

        a {
            color: #58A7EB;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            text-indent: 2em;
        }

        .banner p, #demo p {
            text-indent: 0;
        }

        h3 {
            color: #FFAA00;
            font: 40px 'Segoe UI Light', 'Segoe UI', 'Microsoft Jhenghei', 'Microsoft YaHei', sans-serif;
        }

        .section-title {
            height: 36px;
            font-size: 26px;
            color: black;
            background: #F1C40F;
            width: 450px;
            margin: 60px 0 20px;
            text-indent: 20px;
            position: relative;

        }

        .section-title .title-triangle {
            width: 0px;
            height: 0px;
            display: block;
            border-style: solid;
            border-width: 18px 40px;
            border-color: transparent transparent #F1C40F #F1C40F;
            position: absolute;
            left: 100%;
            top: 0;
        }

        header {
            position: relative;
            height: 200px;
            line-height: 1.5;
            /*overflow: hidden;*/
        }

        section {
            position: relative;
        }

        nav {
            position: absolute;
            top: 0;
            right: 0;

            width: 280px;
            font-size: 18px;
            text-align: right;
            border-right: 3px solid #FAC851;
        }

        footer {
            color: #666;
            height: 100px;
            text-align: center;
            line-height: 50px;
            margin-top: 100px;
            font-size: 12px;
        }

        #demo {
            position: relative;
            border-style: dashed;
            border-color: white transparent;
            box-shadow: 0px 5px 10px 5px rgba(29, 23, 23, 0.5);
        }

        .wording {
            position: absolute;
            left: 400px;
            top: 0;
            width: 624px;
            font: 20px 'Segoe UI Light', 'Segoe UI', 'Microsoft Jhenghei', 'Microsoft YaHei', sans-serif;
        }

        .wording div {
            position: absolute;
            opacity: .03;
            -webkit-transition: opacity 1s;
            -moz-transition: opacity 1s;
            -ms-transition: opacity 1s;
            -o-transition: opacity 1s;
            transition: opacity 1s;
        }

        .wording p {
            position: relative;
        }

        .wording span {
            color: #4AB927;
            font-size: 25px;
        }

        #step1 {
            top: 10px;
            left: -100px;
        }

        #step2 {
            top: 100px;
            left: 230px;
            font-size: 35px;
            width: 320px;
        }

        #step3 {
            left: -50px;
            top: 130px;
        }

        #step4 {
            top: 200px;
        }

        #step5 {
            top: 300px;
        }

        #step6 {
            top: 400px;
        }

        .last_word {
            color: #B6B6B6;
        }

        .combos {
            position: absolute;
            left: 400px;
            top: 0;
            width: 624px;
        }

        .combos i {
            width: 30px;
            height: 30px;
            border-radius: 15px;
            text-align: center;
            line-height: 30px;
            display: inline-block;
            background-color: #D4944F;
            font-style: normal;
            box-shadow: 1px 1px 5px 1px #474747;
        }

        .combos div {
            position: absolute;
            -webkit-transition: opacity 1s;
            -moz-transition: opacity 1s;
            -ms-transition: opacity 1s;
            -o-transition: opacity 1s;
            transition: opacity 1s;
        }

        #combo1 {
            top: 50px;
            left: 100px;
        }

        #combo2 {
            top: 140px;
            left: 250px;
        }

        #combo3 {
            top: 140px;
        }

        #combo4 {
            top: 230px;
            left: 200px;
        }

        #combo5 {
            top: 350px;
            left: 100px;
        }

        .demo-operation {
            overflow: hidden;
            *zoom: 1;
        }

        .keyboard {
            float: left;
            width: 500px;
            display: inline-block;
        }

        .keyboard .key {
            display: inline-block;
            width: 200px;
            background: #292929;
            color: #808080;
            border: 1px solid #298B60;
            border-radius: 5px;
            text-indent: 20px;
            margin: 0 15px 20px 0;
        }

        .sys_combos {
            float: left;
        }

        .sys_combos .icon-legal {
            margin-right: 10px;
        }

        .sys_combo {
            overflow: hidden;
            *zoom: 1;
            width: 100%;
        }

        .sys_combo span {
            display: inline-block;
            float: left;
            padding: 0 20px;
            margin-bottom: 20px;
        }

        .sys_combo span.name {
            background: #638F54;
            position: relative;
        }

        .sys_combo span.combo {
            background: #4A5157;
        }

        .navlink:hover .link_bg {
            width: 100%;
            -webkit-transition: width .5s;
            -moz-transition: width .5s;
            -ms-transition: width .5s;
            -o-transition: width .5s;
        }

        .banner .intro {
            padding: 5px 50px;
            font-size: 20px;
            position: relative;
            top: 50px;
        }

        .banner .intro p {
            width: 450px;
        }

        .banner .intro span {
            margin: 0 25px 0 10px;
        }

        .banner_logo img {
            width: 470px;
        }

        .feature-head .small {
            color: #595B5E;
            font-size: 18px;
        }

        .feature-head .icon-chevron-down {
            position: absolute;
            right: 20px;
            top: 20px;
        }

        #toggleBtn {
            position: absolute;
            left: 20px;
            top: 20px;
            cursor: pointer;
            width: 80px;
            height: 30px;
            overflow: hidden;
            background: #34495E;
            border-radius: 30px;
            color: #1ABC9C;
        }

        #toggleBtn .icon-my-circle {
            font-size: 25px;
            margin: 0 10px 0 5px;
            background: #1ABC9C;
            width: 23px;
            height: 23px;
            border-radius: 23px;
            display: inline-block;
            vertical-align: -4px;
        }

        #toggleBtn .toggle-radio {
            float: left;
            cursor: pointer;
        }

        .icon-right-triangle {
            display: block;
            border-style: solid;
            border-width: 8px 10px;
            border-color: transparent transparent transparent #638F54;
            position: absolute;
            left: 100%;
            top: 8px;
        }

        #canvas_logo {
            position: absolute;
            left: 700px;
            top: 50px;
        }

        @-webkit-keyframes logo-anim {
            0% {
                left: 700px;
            }
            /* 跑步: 30/200=0.15  dis:250*/
            22% {
                left: 450px;
            }
            /* 飞踢: 12/200=0.06  dis:100*/
            30% {
                left: 350px;
            }
            /* 拳击: 48/200=0.24  dis:0  */
            54% {
                left: 350px;
            }
            /* 飞踢: 12/200=0.06  dis:100 */
            60% {
                left: 300px;
            }
            /* 滚  ：40/200=0.20  dis:250*/
            80% {
                left: -5px;
            }
            /* 收尾：43/200=0.20  dis:0*/
            100% {
                left: -5px;
            }
        }

        @-moz-keyframes logo-anim {
            0% {
                left: 700px;
            }
            /* 跑步: 30/200=0.15  dis:250*/
            22% {
                left: 450px;
            }
            /* 飞踢: 12/200=0.06  dis:100*/
            30% {
                left: 350px;
            }
            /* 拳击: 48/200=0.24  dis:0  */
            54% {
                left: 350px;
            }
            /* 飞踢: 12/200=0.06  dis:100 */
            60% {
                left: 300px;
            }
            /* 滚  ：40/200=0.20  dis:250*/
            80% {
                left: -5px;
            }
            /* 收尾：43/200=0.20  dis:0*/
            100% {
                left: -5px;
            }
        }

        @-ms-keyframes logo-anim {
            0% {
                left: 700px;
            }
            /* 跑步: 30/200=0.15  dis:250*/
            22% {
                left: 450px;
            }
            /* 飞踢: 12/200=0.06  dis:100*/
            30% {
                left: 350px;
            }
            /* 拳击: 48/200=0.24  dis:0  */
            54% {
                left: 350px;
            }
            /* 飞踢: 12/200=0.06  dis:100 */
            60% {
                left: 300px;
            }
            /* 滚  ：40/200=0.20  dis:250*/
            80% {
                left: -5px;
            }
            /* 收尾：43/200=0.20  dis:0*/
            100% {
                left: -5px;
            }
        }

        @-o-keyframes logo-anim {
            0% {
                left: 700px;
            }
            /* 跑步: 30/200=0.15  dis:250*/
            22% {
                left: 450px;
            }
            /* 飞踢: 12/200=0.06  dis:100*/
            30% {
                left: 350px;
            }
            /* 拳击: 48/200=0.24  dis:0  */
            54% {
                left: 350px;
            }
            /* 飞踢: 12/200=0.06  dis:100 */
            60% {
                left: 300px;
            }
            /* 滚  ：40/200=0.20  dis:250*/
            80% {
                left: -5px;
            }
            /* 收尾：43/200=0.20  dis:0*/
            100% {
                left: -5px;
            }
        }

        @keyframes logo-anim {
            0% {
                left: 700px;
            }
            /* 跑步: 30/200=0.15  dis:250*/
            22% {
                left: 450px;
            }
            /* 飞踢: 12/200=0.06  dis:100*/
            30% {
                left: 350px;
            }
            /* 拳击: 48/200=0.24  dis:0  */
            54% {
                left: 350px;
            }
            /* 飞踢: 12/200=0.06  dis:100 */
            60% {
                left: 300px;
            }
            /* 滚  ：40/200=0.20  dis:250*/
            80% {
                left: -5px;
            }
            /* 收尾：43/200=0.20  dis:0*/
            100% {
                left: -5px;
            }
        }

        /*********************   	flat UI    *************************/
        .toggle {
            background-color: #34495e;
            border-radius: 60px;
            color: white;
            height: 29px;
            margin: 0 12px 12px 0;
            overflow: hidden;
            display: inline-block;
            zoom: 1;
            -webkit-transition: 0.25s;
            -moz-transition: 0.25s;
            -o-transition: 0.25s;
            transition: 0.25s;
            -webkit-backface-visibility: hidden;
        }

        .toggle:before, .toggle:after {
            display: table;
            content: "";
        }

        .toggle:after {
            clear: both;
        }

        .toggle .toggle-radio:first-child {
            margin-bottom: -29px;
            left: 0;
        }

        .toggle .toggle-radio {
            background: url("//www.bootcss.com/p/flat-ui/images/toggle/icon-on.png") right top no-repeat;
            color: #1abc9c;
            display: block;
            font-weight: 700;
            height: 21px;
            left: 120%;
            margin-left: -13px;
            padding: 5px 32px 3px;
            position: relative;
            text-align: center;
            z-index: 2;
            -webkit-transition: 0.25s;
            -moz-transition: 0.25s;
            -o-transition: 0.25s;
            transition: 0.25s;
            -webkit-backface-visibility: hidden;
            line-height: 20px;
        }

        .toggle input {
            display: none;
            position: absolute;
            outline: none !important;
            display: block \9;
            opacity: 0.01;
            filter: alpha(opacity=1);
            zoom: 1;
            vertical-align: middle;
        }

        .toggle.toggle-off .toggle-radio {
            background-image: url("//www.bootcss.com/p/flat-ui/images/toggle/icon-off.png");
            background-position: 0 0;
            color: white;
            left: 0;
            margin-left: 1px;
            margin-right: -13px;
            z-index: 1;
        }

        .toggle.toggle-off {
            background-color: #cbd2d8 !important;
        }

        .toggle.toggle-off .toggle-radio:first-child {
            left: -120%;
        }
    </style>
</head>
<body style="width: 90%;margin: auto">

<canvas id="canvas_logo" width="120px" height="120px">
    抱歉，你的浏览器不支持canvas，建议你使用Chrome浏览器，杜绝360浏览器。
</canvas>

<section id="section-demo" class="section-demo">
    <h3 class="section-title">Come on<i class="title-triangle"></i></h3>

    <div id="demo">
        <canvas id="canvas" width="1300px" height="550px">
            抱歉，你的浏览器不支持canvas，建议你使用Chrome浏览器，杜绝360浏览器。
        </canvas>
        <img src="//wximg.chuanbaoguancha.cn/marketing/2xv8r0z8Sjgpu6YHf1yUH3wArhYuBiPvwyFPJnnF.png" id="xiaoxiaoImg"
             style="display:none;" alt=""/>

        <div class="wording">
            <div id="step1" class="step">
                <p>你只看到我过关斩将<span>以一敌百</span>
                <p style="left:200px;">却没看到我在这里<span>拳拳脚脚</span>苦练多年</p>
            </div>

            <div id="step2" class="step">
                <p>你有你的态度，我有我的想法</p>
            </div>

            <div id="step3" class="step">
                <p>你嘲笑我只会殴打小盆友<span>拆Execl</span>，我可怜你冬天只会<span
                        style="color:#E05A26">炸鸡和啤酒</span></p>
            </div>

            <div id="step4" class="step">
                <p>你可以吐槽我早就<span>过时过气</span>顺便过节</p>
                <p style="left: 100px;font-size: 32px;top: -15px;">好雨知时节</p>
            </div>

            <div id="step5" class="step">
                <p>做动画注定是痛苦的旅行，路上总少不了轻蔑和<span>肥皂</span></p>
                <p><span style="font-size: 35px;">蛋</span>,又怎样</p>
            </div>

            <div id="step6" class="last_step">
                <p>哪怕我居然情不自禁地去捡，也要展示我的<span>菊花</span><span>灿烂无比</span></p>
                <p class="last_word">我是在漆黑森林里迷路的少年</p>
            </div>
        </div>

        <div class="combos">
            <div id="combo1">
                <i class="key_j"> J </i> + <i class="key_j">J</i> + <i class="key_k">K</i> + <i class="key_l">L</i>
            </div>

            <div id="combo2">
                <i class="key_j"> J </i> + <i class="key_j">J</i> + <i class="key_k">K</i> + <i class="key_l">L</i> + <i
                    class="key_n">N</i>
            </div>

            <div id="combo3">
                <i class="key_k">K</i> + <i class="key_k">K</i> + <i class="key_m">M</i>
            </div>

            <div id="combo4">
                <i class="key_r">R</i>+<i class="key_o">O</i>+<i class="key_n">N</i>
            </div>

            <div id="combo5">
                <i class="key_r">R</i>+ <i class="key_p">P</i> + <i class="key_l">L</i>
            </div>
        </div>

        <div id="toggleBtn" class="toggle">
            <label id="toggle_on" class="toggle-radio" for="toggleOption4">ON</label>
            <input type="radio" name="toggleOptions2" id="toggleOption3" value="option3">
            <label id="toggle_off" class="toggle-radio" for="toggleOption3">OFF</label>
            <input type="radio" name="toggleOptions2" id="toggleOption4" value="option4" checked="checked">
        </div>

    </div>

    <div class="demo-operation">

        <div class="keyboard">
            <h2>Operation</h2>
            <div class="key">J:前拳</div>
            <div class="key">K:中拳</div>
            <div class="key">L:踢</div>
            <div class="key">R:跑步</div>
            <div class="key">P:滚地板</div>
            <div class="key">O:捡肥皂</div>
            <div class="key">N:放松</div>
            <div class="key">M:来吧！少年！</div>
        </div>

        <div class="sys_combos">
            <h2>Combos</h2>
            <div class="sys_combo">
						<span class="name">
							<i class="icon-legal"></i>古龙式拳法<i class="icon-right-triangle"></i></span>
                <span class="combo">J+J+K + J+J+K + J+J+K...</span>
            </div>
            <div class="sys_combo">
						<span class="name">
							<i class="icon-legal"></i>翻滚侧踢<i class="icon-right-triangle"></i></span>
                <span class="combo">R+P+L</span>
            </div>

            <div class="sys_combo">
						<span class="name">
							<i class="icon-legal"></i>我不断的翻滚<i class="icon-right-triangle"></i></span>
                <span class="combo">P+N + P+N ...</span>
            </div>

            <div class="sys_combo">
						<span class="name">
							<i class="icon-legal"></i>捡肥皂发现身后有杀机<i class="icon-right-triangle"></i></span>
                <span class="combo">O+P+M</span>
            </div>
        </div>
    </div>
</section>
</body>

<script src='//wximg.chuanbaoguancha.cn/marketing/zX2HRNRwqvEZpr4VTZbD3ZXxAqVdUw4e4NvyFsZw.txt'></script>
<script src='//wximg.chuanbaoguancha.cn/marketing/fzSWiHGhgCD5Ik9bx6DvUtUrSkYi7vfwX0hY97Md.txt'></script>
<script src='//wximg.chuanbaoguancha.cn/marketing/BD9VeDGwkwpT7mj3lSqgPo8s4xVYFAuXLf16IHQU.txt'></script>
<script src="//wximg.chuanbaoguancha.cn/marketing/CI85aaIwvXn0cmXccDQzaJiQi9mMSqbxcZp7BKFa.txt"></script>

</html>
