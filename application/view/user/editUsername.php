<div class="container">
    <h1>UserController/editUsername</h1>
    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>
    <h2>Change your username</h2>
    <form action="<?php echo Config::get('URL'); ?>user/editUserName_action" method="post">
        <div class="form-group">
            <label>New username:</label>
            <input type="text" class="form-control" name="user_name" placeholder="Enter a username" required>
        </div>
        <!-- set CSRF token at the end of the form -->
        <input type="hidden" name="csrf_token" value="<?= Csrf::makeToken(); ?>" />
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>