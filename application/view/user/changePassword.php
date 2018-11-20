<div class="container">
    <h1>UserController/changePassword</h1>
    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>
    <h2>Set new password</h2>
    <!-- new password form box -->
    <form method="post" action="<?php echo Config::get('URL'); ?>user/changePassword_action" name="new_password_form">
        <div class="form-group">
            <label>Enter Current Password:</label>
            <input type="password" class="form-control" name='user_password_current' pattern=".{6,}" required autocomplete="off">
        </div>
        <div class="form-group">
            <label>Enter Current Password:</label>
            <input type="password" class="form-control" name='user_password_new' pattern=".{6,}" required autocomplete="off">
        </div>
        <div class="form-group">
            <label>Enter Current Password:</label>
            <input type="password" class="form-control" name='user_password_repeat' pattern=".{6,}" required autocomplete="off">
        </div>
        <button type="submit" name="submit_new_password" class="btn btn-primary">Submit</button>
    </form>
</div>