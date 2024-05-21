

<?php



//session_start();
//setcookie('userId', '1', time() + 60 * 60 * 24 * 7, '/');

//echo 'This is cookie: '.$_COOKIE['userId'];
//echo 'This is session: '.$_SESSION['userId'];
    
include 'header.php';
    
//    echo '<div class="main"> </div>';


//include './template/header.html';

//echo '<div class="main"> </div>';
include './template/home2.php';


include './template/footer.html';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#home').addClass('active-page');
    });
</script>