<div class="container">
    <h1>Edit your avatar</h1>
    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>
    <div class="alert alert-info" role="alert">
        If you still see the old picture after uploading a new one: Hard-Reload the page with F5! Your browser doesn't
        realize there's a new image as new and old one have the same filename.
    </div>
    <div class="row">
        <div class="col">
            <h3>Upload an Avatar</h3>
            <form action="<?php echo Config::get('URL'); ?>user/uploadAvatar_action" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleFormControlFile1">Select an avatar image from your hard-disk (will be scaled to 44x44 px, only .jpg currently):</label>
                    <input type="file" class="form-control-file" name="avatar_file" required >
                    <!-- max size 5 MB (as many people directly upload high res pictures from their digital cameras) -->
                    <input type="hidden" name="MAX_FILE_SIZE" value="5000000" />
                    <button type="submit" class="btn btn-primary mt-2">Upload image</button>
                </div>
            </form>
        </div>
        <div class="col">
            <h3>Delete your avatar</h3>
            <p>Click this link to delete your (local) avatar: <a href="<?php echo Config::get('URL'); ?>user/deleteAvatar_action">Delete your avatar</a>
        </div>
    </div>
</div>
