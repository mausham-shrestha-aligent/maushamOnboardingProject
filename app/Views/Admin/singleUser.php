<div class="col-lg-12 col-xl-11">
    <div class="card text-black" style="border-radius: 25px;">
        <div class="card-body p-md-5">
            <a href="/posts?<?= $this->params['id'] ?>">
                <button type="button" class="btn btn-secondary-outline">Post From this user</button>
            </a>
            <a href="/comments?<?= $this->params['id'] ?>">
                <button type="button" class="btn btn-primary">comments from this user</button>
            </a>
            <?php if (getCurrentUserId() != $this->params['id']): ?>
                <a href="/delete-user-admin?<?= $this->params['id'] ?>" style="float: right">
                    <button type="button" class="btn btn-danger">Delete this user</button>
                </a>
            <?php endif; ?>

            <div style="min-width: 100%">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Change Account Details</p>
                <form action="/users/register/updateUser" method="post">
                    <div class="col-lg-6 offset-lg-3 col-md-4 offset-md-3">
                        <form class="mx-1 mx-md-4" action="/users/register/updateUser" method="post">
                            <input type="hidden" value="<?= $this->params['id'] ?>" name="userId"/>
                            <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="text" id="form3Example1c" class="form-control"
                                       name="name" value="<?= $this->params['name'] ?>"/>
                                <label class="form-label" for="form3Example1c">Your Name</label>
                            </div>
                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="email" id="form3Example3c" class="form-control"
                                       name="email" value="<?= $this->params['email'] ?>"/>
                                <label class="form-label" for="form3Example3c">Your Email</label>
                            </div>
                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="password" id="form3Example4c" class="form-control"
                                       name="password" Value="<?= $this->params['password'] ?>"/>
                                <label class="form-label" for="form3Example4c">Password</label>
                            </div>
                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <label class="form-label" for="form3Example4c">User Access Level</label>&nbsp;&nbsp
                                <select name="accessLevel">
                                    <option value="<?= $this->params['accessLevel'] ?>"><?= $this->params['accessLevel'] ?></option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                </select>
                            </div>
                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                            <div class="form-outline flex-fill mb-0">
                                <input type="text" id="form3Example4c" class="form-control"
                                       name="userProfilePic" value="<?= $this->params['userProfilePic'] ?>"/>
                                <label class="form-label" for="form3Example4c">Profile Pic URL</label>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg">Submit Changes for this user</button>
                    </div>
                </form>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

