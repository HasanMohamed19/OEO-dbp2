<?php
include 'debugging.php';

if (isset($_POST['submitted'])) {
    $user = new User();
    $user->setEmail($_POST['Email']);
    $user->setUsername($_POST['UName']);
    $user->setPassword($_POST['Password']);

    if ($user->initWithUsername()) {

        if ($user->registerUser())
            echo 'Registerd Successfully';
        else
            echo '<p class="error"> Not Successfull </p>';
    }else {
        echo '<p class="error"> Username Already Exists </p>';
    }
}

include 'header.html';
?>

<h1>User Registration</h1>
<div id="stylized" class="myform"> 
    <form action="register2.php" method="post">
        <table alig="center" cellpadding="5" cellspacing="5" border="0" width="50%" >
            <tr><th>Enter Username</th>
                <td><input type="text" name="UName" size="20" value="" /></td>
            </tr>
            <tr><th>Enter First Name</th>
                <td><input type="text" name="FName" size="20" value="" /></td>
            </tr>
            <tr><th>Enter Last Name</th>
                <td><input type="text" name="LName" size="20" value="" /></td>
            </tr>
            <tr><th>Enter Email</th>
            <td><input type="email" name="Email" size="50" value="" /></td></tr>
            <tr><th>Enter Password</th>
            <td><input type="password" name="Password" size="10" value="" /></td></tr>
            <tr><td></td><td>
                <input type ="submit" value ="Register" />
                </td> </tr> 
            <input type="hidden" name="submitted" value="1" />
        </table>
    </form>    
    <div class="spacer"></div>;    
</div>    
<?php
include 'footer.html';
?>