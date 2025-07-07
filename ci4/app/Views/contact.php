<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        #kontak {
            padding: 20px;
        }
        .info-kontak {
            background-color: #f9f9f9;
            padding: 20px;
            border-left: 4px solid #2196F3;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <?= $this->include('template/header'); ?>

    <section id="kontak">
        <div class="info-kontak">
            <h3>Informasi Kontak</h3>
            <p><strong>Nama:</strong> Fakhri Afif</p>
            <p><strong>Alamat:</strong> Telaga Murni</p>
            <p><strong>Email:</strong> <a href="mailto:fakhriafif345@gmail.com">fakhriafif345@gmail.com</a></p>
            <p><strong>Hal menarik:</strong> Saya memiliki ketertarikan besar pada dunia pendidikan, terutama dalam membagikan ilmu yang bermanfaat kepada orang lain. Selain itu, saya juga memiliki hobi dan pengetahuan dalam bidang otomotif, mulai dari pemeliharaan kendaraan hingga teknologi mesin modern.</p>
        </div>
    </section>

    <?= $this->include('template/footer'); ?>
</body>
</html>
