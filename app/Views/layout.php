<!-- app/Views/layout.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Admin' ?> - Caldera Insight</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            min-width: 250px;
            max-width: 250px;
            background-color: #343a40;
            padding: 20px;
            color: #fff;
        }

        .sidebar a {
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            margin-bottom: 5px;
            border-radius: 5px;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        .sidebar h3 {
            margin-bottom: 20px;
        }

        .sidebar h3::after {
            content: " Insight";
            color: #ff0000;
        }
    </style>
</head>

<body>
    <?= $this->include('sidebar') ?>
    <div class="content">
        <?= $this->renderSection('content') ?>
    </div>


</body>

</html>