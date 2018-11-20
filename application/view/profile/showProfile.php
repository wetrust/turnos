<div class="container">
    <h1>ProfileController/showProfile/:id</h1>
    <?php $this->renderFeedbackMessages(); ?>
    <h3>What happens here ?</h3>
    <p>This controller/action/view shows all public information about a certain user.</p>
    <?php if ($this->user) { ?>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>Id</th>
                <th>Avatar</th>
                <th>Username</th>
                <th>User's email</th>
                <th>Activated ?</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $this->user->user_id; ?></td>
                <td class="avatar">
                <?php if (isset($this->user->user_avatar_link)) { ?>
                    <img src="<?= $this->user->user_avatar_link; ?>" />
                <?php } ?>
                </td>
                <td><?= $this->user->user_name; ?></td>
                <td><?= $this->user->user_email; ?></td>
                <td><?= ($this->user->user_active == 0 ? 'No' : 'Yes'); ?></td>
            </tr>
        </tbody>
    </table>
    <?php } ?>
</div>