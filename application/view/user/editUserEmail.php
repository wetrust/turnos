<div class="container">
    <h1>UserController/editUserEmail</h1>
    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>
    <h2>Change your email address</h2>
    <form action="<?php echo Config::get('URL'); ?>user/editUserEmail_action" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">New email address:</label>
            <input type="email" class="form-control" name="user_email" aria-describedby="emailHelp" placeholder="Enter email" required>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
