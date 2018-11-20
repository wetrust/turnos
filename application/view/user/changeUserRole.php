<div class="container">
    <h1>UserController/changeUserRole</h1>
    <?php $this->renderFeedbackMessages(); ?>
    <h2>Change account type</h2>
    <p>
        This page is a basic implementation of the upgrade-process.
        User can click on that button to upgrade their accounts from
        "basic account" to "premium account". This script simple offers
        a click-able button that will upgrade/downgrade the account instantly.
        In a real world application you would implement something like a pay-process.
    </p>
	<p>
	    Please note: This whole process has been renamed from AccountType (v3.0) to UserRole (v3.1).
	</p>
    <h2>Currently your account type is: <?php echo Session::get('user_account_type'); ?></h2>
    <!-- basic implementation for two account types: type 1 and type 2 -->
	<form action="<?php echo Config::get('URL'); ?>user/changeUserRole_action" method="post">
        <?php if (Session::get('user_account_type') == 1) { ?>
            <button type="submit" name="user_account_upgrade" value="2" class="btn btn-primary">Upgrade my account (to Premium User)</button>
	    <?php } else if (Session::get('user_account_type') == 2) { ?>
	        <button type="submit" name="user_account_downgrade" value="1" class="btn btn-primary">Downgrade my account (to Basic User)</button>
	    <?php } ?>
	</form>
</div>