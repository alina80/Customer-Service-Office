<div class="row" id="content">
    <div class="col-md-12">
        <div class="page-header">
            <h2>Sign in</h2>
        </div>
        <form  method="post" action="../controllers/LoginController.php">

            <div class="row">
                <div class="col-4">
                    <label for="login">Login:</label>
                    <input type="text" class="form-control" id="login" name="login">
                </div>
                <div class="col-4">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd" name="password">
                </div>

            </div>

            <div class="row">
                <div class="col mt-2">
                    <button type="submit" class="btn btn-success">Sign in</button>
                </div>
            </div>
        </form>

        <form class="form-group" action="../controllers/RegisterController.php" method="get">
            <div class="row">
                <div class="col mt-2">
                    <button type="submit" class="btn btn-primary">Create an account</button>
                </div>
            </div>
        </form>
    </div>
</div>
