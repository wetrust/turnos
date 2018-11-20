<div class="container">
    <h1>NoteController/index</h1>
    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>
    <h3>What happens here ?</h3>
    <p>This is just a simple CRUD implementation. Creating, reading, updating and deleting things.</p>
    <form method="post" action="<?php echo Config::get('URL');?>note/create">
        <div class="form-group">
            <label>Text of new note:</label>
            <input type="text" class="form-control" name="note_text" autocomplete="off">
            
        </div>
        <button type="submit" class="btn btn-primary">Create this note</button>
    </form>
    <?php if ($this->notes) { ?>
    <table class="table table-bordered mt-2">
        <thead class="thead-dark">
            <tr>
                <th>Id</th>
                <th>Note</th>
                <th>EDIT</th>
                <th>DELETE</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($this->notes as $key => $value) { ?>
            <tr>
                <td><?= $value->note_id; ?></td>
                <td><?= htmlentities($value->note_text); ?></td>
                <td><a href="<?= Config::get('URL') . 'note/edit/' . $value->note_id; ?>">Edit</a></td>
                <td><a href="<?= Config::get('URL') . 'note/delete/' . $value->note_id; ?>">Delete</a></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
    <div class="alert alert-info mt-2" role="alert">No notes yet. Create some !</div>
    <?php } ?>
</div>
