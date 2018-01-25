<div class="container">
    <div class="d-flex p-2 justify-content-center">
        <div class="card">
            <div class="card-body">
            <?php $this->renderFeedbackMessages(); ?>
                <h5 class="card-title">Set new password</h5>
                <form action="<?php echo Config::get('URL'); ?>login/setNewPassword" method="post">
                    <input type='hidden' name='user_name' value='<?php echo $this->user_name; ?>' />
                    <input type='hidden' name='user_password_reset_hash' value='<?php echo $this->user_password_reset_hash; ?>' />
                    <div class="form-group">
                        <label>New password (min. 6 characters)</label>
                        <input class="form-control" type="password" name="user_password_new" pattern=".{6,}" required />
                    </div>
                    <div class="form-group">
                        <label>Repeat new password</label>
                        <input class="form-control" type="password" name="user_password_repeat" pattern=".{6,}" required />
                    </div>
                    <input type="submit" class="btn btn-primary my-2" value="Submit new password"/>
                </form>
                <a href="<?php echo Config::get('URL'); ?>login/index">Back to Login Page</a>
            </div>
        </div>
    </div>
</div>
