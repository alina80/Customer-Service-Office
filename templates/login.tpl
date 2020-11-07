<div class="row" id="content">
    <div class="col-md-12">
        <div class="page-header">
            <h2>Sign in</h2>
        </div>
        <form class="form-inline" method="post" action="../controllers/LoginController.php">
            <div class="form-group">
                <label for="login">Login:</label>
                <input type="text" class="form-control" id="login" name="login">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" name="password">
            </div>
            <button type="submit" class="btn btn-default">Sign in</button>
        </form>
        <form action="../controllers/RegisterController.php" method="get">
            <button type="submit" class="btn btn-primary">Create an account</button>
        </form>
    </div>
</div>
