
    <?php
    $ses_userid = $_SESSION['ses_userid'];
    $ses_username = $_SESSION['ses_username'];
    
    if ($ses_userid <> session_id() or $ses_username == "") {
        $statusLogin = false;
        
    } else {
        $statusLogin = true;
        ?>
        <?php
    }
    ?>