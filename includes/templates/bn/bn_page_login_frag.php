<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title></title>
    <?php
    if(WoW_Account::IsLoggedIn()) {
        echo '<script>parent.postMessage("{\"action\":\"success\",\"loginTicket\":\"' . WoW_Account::GetSessionInfo('wow_account_hash') . '\"}", "/");</script>';
    }
    else {
        WoW_Template::LoadTemplate('block_login_frag', true);
    }
    ?>
</head>
</html>