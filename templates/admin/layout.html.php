<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link href="css/admin.css" rel="stylesheet">

    <title>[Admin] <?= filter_var($pageTitle, FILTER_SANITIZE_STRING) ?> - My Blog</title>

</head>
<body class="container-fluid p-0 pt-5">

    <?= filter_var($pageHeader) ?>

    <div class="container-fluid pt-3">
        <div class="row">

            <?= filter_var($pageSidebar) ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            
                    <h1><?= filter_var($pageTitle, FILTER_SANITIZE_STRING) ?></h1>
                    
                    <?= filter_var($alert) ?>
                    <?= filter_var($pageContent) ?>
    
            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>
</html>
