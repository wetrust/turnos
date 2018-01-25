<div class="container">
    <div class="d-flex p-2 justify-content-center">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Login here</h5>
                <?php $this->renderFeedbackMessages(); ?>
                <form action="<?php echo Config::get('URL'); ?>login/login" method="post">
                    <div class="form-group">
                        <label>Username or email</label>
                        <input class="form-control" type="text" name="user_name" required />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="user_password" required />
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="set_remember_me_cookie"  />
                        <label class="form-check-label">
                            Remember me for 2 weeks
                        </label>
                    </div>
                    <!-- when a user navigates to a page that's only accessible for logged a logged-in user, then
                         the user is sent to this page here, also having the page he/she came from in the URL parameter
                         (have a look). This "where did you came from" value is put into this form to sent the user back
                         there after being logged in successfully.
                         Simple but powerful feature, big thanks to @tysonlist. -->
                    <?php if (!empty($this->redirect)) { ?>
                        <input type="hidden" name="redirect" value="<?php echo $this->encodeHTML($this->redirect); ?>" />
                    <?php } ?>
					<!--
						set CSRF token in login form, although sending fake login requests mightn't be interesting gap here.
						If you want to get deeper, check these answers:
							1. natevw's http://stackoverflow.com/questions/6412813/do-login-forms-need-tokens-against-csrf-attacks?rq=1
							2. http://stackoverflow.com/questions/15602473/is-csrf-protection-necessary-on-a-sign-up-form?lq=1
							3. http://stackoverflow.com/questions/13667437/how-to-add-csrf-token-to-login-form?lq=1
					-->
					<input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>" />
                    <input type="submit" class="btn btn-primary my-2" value="Log in"/>
                </form>
                <a class="btn btn-secondary my-2" href="<?php echo Config::get('URL'); ?>login/requestPasswordReset">I forgot my password</a> | <a class="btn btn-secondary my-2" href="<?php echo Config::get('URL'); ?>register/index">Register</a>
            </div>
        </div>
    </div>
</div>
