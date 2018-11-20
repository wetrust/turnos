<div class="container">
    <h1>NoteController/edit/:note_id</h1>
    <h2>Edit a note</h2>
    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>
    <?php if ($this->note) { ?>
    <form method="post" action="<?php echo Config::get('URL'); ?>note/editSave">
        <!-- we use htmlentities() here to prevent user input with " etc. break the HTML -->
        <input type="hidden" name="note_id" value="<?php echo htmlentities($this->note->note_id); ?>" />
        <div class="form-group">
            <label>Change text of note:</label>
            <input type="text" class="form-control" name="note_text" value="<?php echo htmlentities($this->note->note_text); ?>">
        </div>
        <button type="submit" class="btn btn-primary">Change</button>
    </form>
    <?php } else { ?>
    <div class="alert alert-danger" role="alert">This note does not exist.</div>
    <?php } ?>
</div>