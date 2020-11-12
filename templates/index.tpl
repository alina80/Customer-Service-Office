<!DOCTYPE html>
<html>
    <head>
        <title>CustomerServiceOffice</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/main.css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>
    <body>


    <div class="container">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-dark bg-info fixed-top">
                <a class="navbar-brand" href="#">Customer Service Office</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <div class="nav-link">Logged in as: {{login}} </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../controllers/LogoutController.php">Log out</a>
                            </li>
                        </ul>
                    </div>


            </nav>
        </div>
        <div class="row mt-5"></div>

        <div class="mt-5">
            {{content}}
        </div>

    </div>

    </body>
</html>
