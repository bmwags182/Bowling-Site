<?php
/*-------------------------------------------------------+
| Bowling Statistics
| Add New Game Page
+--------------------------------------------------------+
| Author: Bret Wagner  Email: bretwagner@bwagner-webdev.com
+--------------------------------------------------------+*/
require('../includes/config.php');

$page['title'] = "New Game";

if(isset($_POST['submit'])){

    $date = strip_tags(mysqli_real_escape_string(db_connect(), $_POST['date']));
    $league_play = strip_tags(mysqli_real_escape_string(db_connect(),$_POST['league_play']));
    $memberID = strip_tags(mysqli_real_escape_string(db_connect(),$_SESSION['memberID']));
    if (isset($_POST['full_game'])) {
        $frames = get_frames($_POST);
        $full_game = mysqli_real_escape_string(db_connect(), $_POST['full_game']);
    } else {
        $frames = '';
        $full_game = mysqli_real_escape_string(db_connect(), 'false');
    }
    $score = strip_tags(mysqli_real_escape_string(db_connect(), $_POST['score']));

    mysqli_query(db_connect(), "INSERT INTO games (member_id,date,league_play,full_game,frames,score) VALUES ('$memberID','$date','$league_play', '$full_game', '$frames','$score')")or die(mysqli_error());
    $_SESSION['success'] = 'Game Added';
    header('Location: '.DIRADMIN);
    exit();

}

include("../includes/admin-header.php");

?>


<div id="content">

<h1>Add Game</h1>

<div class="score-btns">
<button type="button" id="btn0" class="score-btn" data-toggle="tooltip" data-placement="bottom" title="0 Pins knocked down" onclick="" >0</button>
<button type="button" id="btn1" class="score-btn" data-toggle="tooltip" data-placement="bottom" title="1 Pin knocked down" onclick="" >1</button>
<button type="button" id="btn2" class="score-btn" data-toggle="tooltip" data-placement="bottom" title="2 Pins knocked down" onclick="" >2</button>
<button type="button" id="btn3" class="score-btn" data-toggle="tooltip" data-placement="bottom" title="3 Pins knocked down" onclick="" >3</button>
<button type="button" id="btn4" class="score-btn" data-toggle="tooltip" data-placement="bottom" title="4 Pins knocked down" onclick="" >4</button>
<button type="button" id="btn5" class="score-btn" data-toggle="tooltip" data-placement="bottom" title="5 Pins knocked down" onclick="" >5</button>
<button type="button" id="btn6" class="score-btn" data-toggle="tooltip" data-placement="bottom" title="6 Pins knocked down" onclick="" >6</button>
<button type="button" id="btn7" class="score-btn" data-toggle="tooltip" data-placement="bottom" title="7 Pins knocked down" onclick="" >7</button>
<button type="button" id="btn8" class="score-btn" data-toggle="tooltip" data-placement="bottom" title="8 Pins knocked down" onclick="" >8</button>
<button type="button" id="btn9" class="score-btn" data-toggle="tooltip" data-placement="bottom" title="9 Pins knocked down" onclick="" >9</button>
<button type="button" id="btn10" class="score-btn" data-toggle="tooltip" data-placement="bottom" title="10 Pins knocked down" onclick="" >10</button>
</div>

<!-- TESTING THIS ROW -->

<div class="game-row">
    <div class="frame" id="frame1">
        <div class="frame-header"><p class="frame-title">1</p></div>
        <div class="frame-body">
        <div class="frame-top">
            <div class="ballbox"><p id="ball11"></p></div>
            <div class="strikebox"><p id="ball12"></p></div>
        </div>
        <div class="scorebox"><p id="score1"></p></div>
        </div>

    </div>
    <div class="frame" id="frame2">
        <div class="frame-header"><p class="frame-title">2</p></div>
        <div class="frame-body">
        <div class="frame-top">
            <div class="ballbox"><p id="ball21"></p></div>
            <div class="strikebox"><p id="ball22"></p></div>
        </div>
        <div class="scorebox"><p id="score2"></p></div>
        </div>
    </div>
    <div class="frame" id="frame3">
        <div class="frame-header"><p class="frame-title">3</p></div>
        <div class="frame-body">
        <div class="frame-top">
            <div class="ballbox"><p id="ball31"></p></div>
            <div class="strikebox"><p id="ball32"></p></div>
        </div>
        <div class="scorebox"><p id="score3"></p></div>
        </div>
    </div>
    <div class="frame" id="frame4">
        <div class="frame-header"><p class="frame-title">4</p></div>
        <div class="frame-body">
        <div class="frame-top">
            <div class="ballbox"><p id="ball41"></p></div>
            <div class="strikebox"><p id="ball42"></p></div>
        </div>
        <div class="scorebox"><p id="score4"></p></div>
        </div>
    </div>
    <div class="frame" id="frame5">
        <div class="frame-header"><p class="frame-title">5</p></div>
        <div class="frame-body">
        <div class="frame-top">
            <div class="ballbox"><p id="ball51"></p></div>
            <div class="strikebox"><p id="ball52"></p></div>
        </div>
        <div class="scorebox"><p id="score5"></p></div>
        </div>
    </div>
    <div class="frame" id="frame6">
        <div class="frame-header"><p class="frame-title">6</p></div>
        <div class="frame-body">
        <div class="frame-top">
            <div class="ballbox"><p id="ball61"></p></div>
            <div class="strikebox"><p id="ball62"></p></div>
        </div>
        <div class="scorebox"><p id="score6"></p></div>
        </div>
    </div>
    <div class="frame" id="frame7">
        <div class="frame-header"><p class="frame-title">7</p></div>
        <div class="frame-body">
        <div class="frame-top">
            <div class="ballbox"><p id="ball71"></p></div>
            <div class="strikebox"><p id="ball72"></p></div>
        </div>
        <div class="scorebox"><p id="score7"></p></div>
        </div>
    </div>
    <div class="frame" id="frame8">
        <div class="frame-header"><p class="frame-title">8</p></div>
        <div class="frame-body">
        <div class="frame-top">
            <div class="ballbox"><p id="ball81"></p></div>
            <div class="strikebox"><p id="ball82"></p></div>
        </div>
        <div class="scorebox"><p id="score8"></p></div>
        </div>
    </div>
    <div class="frame" id="frame9">
        <div class="frame-header"><p class="frame-title">9</p></div>
        <div class="frame-body">
        <div class="frame-top">
            <div class="ballbox"><p id="ball91"></p></div>
            <div class="strikebox"><p id="ball92"></p></div>
        </div>
        <div class="scorebox"><p id="score9"></p></div>
        </div>
    </div>
    <div class="frame" id="frame10">
        <div class="frame-header"><p class="frame-title">10</p></div>
        <div class="frame-body">
            <div class="frame-top">
                <div class="ballbox strikebox10"><p id="ball101"></p></div>
                <div class="strikebox10"><p id="ball102"></p></div>
                <div class="strikebox10"><p id="ball103"></p></div>
            </div>
            <div class="scorebox"><p id="score10"></p></div>
        </div>
        </div>
    </div>

</div>


        <!-- END TESTING ROW -->

<div class="hidden">
<form action="" method="post">
<p>Date:<br /> <input name="date" type="date" value="<?php echo date('Y-m-d'); ?>" placeholder="<?php echo date('Y-m-d'); ?>" size="103" /></p>
<p>League Play:<input name="league_play" type="radio" value="true" />Yes<input type="radio" name="league_play" value="false" />No</p>
<p>Score:<br/><input type="number" name="score"/><br /></p>
<p>Enter all Frames?<input name="full_game" type="radio" value="true" />Yes<input type="radio" name="full_game" value="false" />No</p>
<p>Frame 1:<input type="text" name="frame1a" style="width: 20px;" /><input type="text" name="frame1b" style="width: 20px;" /></p>
<p>Frame 2:<input type="text" name="frame2a" style="width: 20px;"/><input type="text" name="frame2b" style="width: 20px;"/></p>
<p>Frame 3:<input type="text" name="frame3a" style="width: 20px;"/><input type="text" name="frame3b" style="width: 20px;"/></p>
<p>Frame 4:<input type="text" name="frame4a" style="width: 20px;"/><input type="text" name="frame4b" style="width: 20px;"/></p>
<p>Frame 5:<input type="text" name="frame5a" style="width: 20px;"/><input type="text" name="frame5b" style="width: 20px;"/></p>
<p>Frame 6:<input type="text" name="frame6a" style="width: 20px;"/><input type="text" name="frame6b" style="width: 20px;"/></p>
<p>Frame 7:<input type="text" name="frame7a" style="width: 20px;"/><input type="text" name="frame7b" style="width: 20px;"/></p>
<p>Frame 8:<input type="text" name="frame8a" style="width: 20px;"/><input type="text" name="frame8b" style="width: 20px;"/></p>
<p>Frame 9:<input type="text" name="frame9a" style="width: 20px;"/><input type="text" name="frame9b" style="width: 20px;"/></p>
<p>Frame 10:<input type="text" name="frame10a" style="width: 20px;"/><input type="text" name="frame10b" style="width: 20px;"/><input type="text" name="frame10c" style="width: 20px;"/></p>

<p><input type="submit" name="submit" value="Submit" class="button" /></p>
</form>
</div>

</div>

<div id="footer">
        <div class="copy">&copy; <?php echo SITETITLE.' '. date('Y');?> </div>
</div><!-- close footer -->
</div><!-- close wrapper -->

</body>
</html>
