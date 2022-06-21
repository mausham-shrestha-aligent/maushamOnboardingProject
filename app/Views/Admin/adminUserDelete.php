<?php
require_once ROOT_PATH . '/../app/Views/template/header.php';
$userId = explode('?', $_SERVER['REQUEST_URI'])[1];
?>

<div style="text-align: center;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are you sure you want to delete this user?</h5>
            </div>
            <div class="modal-body">
                <p>Deleting user will store the user in deletedUsers table along with comments and post by user</p>
            </div>
            <div class="modal-footer">
                <form action="/delete-user-admin" method="post">
                    <input type="hidden" value="<?= $userId ?>" name="userId">
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <a href="/admin">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>