<div class="container">
    <div class="d-flex p-2 justify-content-center">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Request a password reset</h5>
                <?php $this->renderFeedbackMessages(); ?>
                <form action="<?php echo Config::get('URL'); ?>login/requestPasswordReset_action" method="post">
                    <div class="form-group">
                        <label>Username or email</label>
                        <input class="form-control" type="text" name="user_name_or_email" required />
                    </div>
                    <img class="img-fluid img-thumbnail" id="captcha" src="<?php echo Config::get('URL'); ?>register/showCaptcha" />
                    <div class="form-group">
                        <label>Enter captcha above</label>
                        <input class="form-control" type="text" name="captcha" required />
                        <a href="#" onclick="document.getElementById('captcha').src = '<?php echo Config::get('URL'); ?>register/showCaptcha?' + Math.random(); return false">Reload Captcha</a>
                    </div>
                    <input type="submit" class="btn btn-primary my-2" value="Send me a password-reset mail"/>
                </form>
            </div>
        </div>
    </div>
</div>
