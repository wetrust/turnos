<div class="container">
    <h1>UserController/showProfile</h1>
    <h2>Your profile</h2>
    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>
    <dl class="row">
        <dt class="col-sm-3">Your username:</dt>
        <dd class="col-sm-9"><?= $this->user_name; ?></dd>
        <dt class="col-sm-3">Your email:</dt>
        <dd class="col-sm-9"><?= $this->user_email; ?></dd>
        <dt class="col-sm-3">Your avatar image:</dt>
        <dd class="col-sm-9">
            <?php if (Config::get('USE_GRAVATAR')) { ?>
                Your gravatar pic (on gravatar.com): <img src='<?= $this->user_gravatar_image_url; ?>' />
            <?php } else { ?>
                Your avatar pic (saved locally): <img src='<?= $this->user_avatar_file; ?>' />
            <?php } ?>
        </dd>
        <dt class="col-sm-3">Your account type is:</dt>
        <dd class="col-sm-9"><?= $this->user_account_type; ?></dd>
    </dl>
</div>
