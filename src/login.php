<?php
include("Vue.php");

enTete("Identification");

echo '<section>
        <p> Welcome, guest !
        Please identify below. </p>

        <br/>

        <form action="checkPass.php" method="post">
            <label>Username: </label> <input type="text" name="username"/><br/>
            <label>Password: </label> <input type="password" name="password"/><br/>
            <input type="submit" value="Log in"/>
        </form>
        </section>';
        
echo '<a href="register.php">Don\'t have account yet ? Please register.</a>';

pied();
?>