<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .sidebar h3::first-word {
            color: #ffffff; /* Warna untuk kata "Caldera" */
        }
        .sidebar h3::after {
            content: " Insight"; /* Menambahkan kata " Insight" setelah "Caldera" */
            color: #ff0000; /* Warna untuk kata "Insight" */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="sidebar">
        <h3>Caldera</h3>
        <a href="#" id="home-dashboard">Home Dashboard</a>
        <a href="#" id="tambah-data">Tambah Data</a>
        <a href="#" id="tampil-data">Data Wisata</a>
        <a href="<?= base_url(''); ?>" class="btn btn-danger mt-3">Logout</a>
    </div>
    <div class="content">
        <div class="container mt-5" id="main-content">
            <h1>Welcome to Admin Dashboard - Caldera Insight</h1>
            <p>Manage your website content here.</p>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            $('#tambah-data').click(function(e) {
                e.preventDefault();
                $('#main-content').load('<?= base_url('tambah_data'); ?>');
            });

            $('#tampil-data').click(function(e) {
                e.preventDefault();
                $('#main-content').load('<?= base_url('tampil_data'); ?>');
            });    

            $('#home-dashboard').click(function(e) {
                e.preventDefault();
                $('#main-content').html(`
                    <h1>Welcome to Admin Dashboard</h1>
                    <p>Manage your website content here.</p>
                `);
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
