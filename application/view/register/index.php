<div class="container">
    <div class="d-flex p-2 justify-content-center">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Register a new account</h5>
                <?php $this->renderFeedbackMessages(); ?>
                <form action="<?php echo Config::get('URL'); ?>register/register_action" method="post">
                    <div class="form-group">
                        <label>Username (letters/numbers, 2-64 chars)</label>
                        <input class="form-control" type="text" name="user_name" pattern="[a-zA-Z0-9]{2,64}" required />
                    </div>
                    <div class="form-group">
                        <label>email address (a real address)</label>
                        <input class="form-control" type="text" name="user_email" required />
                    </div>
                    <div class="form-group">
                        <label>repeat email address (to prevent typos)</label>
                        <input class="form-control" type="text" name="user_email_repeat" required />
                    </div>
                    <div class="form-group">
                        <label>Password (6+ characters)</label>
                        <input class="form-control" type="password" name="user_password_new" pattern=".{6,}" required />
                    </div>
                    <div class="form-group">
                        <label>Repeat your password</label>
                        <input class="form-control" type="password" name="user_password_repeat" pattern=".{6,}" required />
                    </div>
                    <img class="img-fluid img-thumbnail" id="captcha" src="<?php echo Config::get('URL'); ?>register/showCaptcha" />
                    <div class="form-group">
                        <label>Enter captcha above</label>
                        <input class="form-control" type="text" name="captcha" required />
                        <a href="#" onclick="document.getElementById('captcha').src = '<?php echo Config::get('URL'); ?>register/showCaptcha?' + Math.random(); return false">Reload Captcha</a>
                    </div>
                    <input type="submit" class="btn btn-primary my-2" value="Register"/>
                </form>
            </div>
        </div>
    </div>
</div>
