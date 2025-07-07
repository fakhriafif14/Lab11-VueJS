<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
    <h1><?= $title; ?></h1>
    <hr>

    <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 20px; margin-top: 20px;">
        <div style="flex: 1; min-width: 250px;">
            <img src="<?= base_url('images/fakhri.jpg'); ?>" alt="Foto Fakhri Afif" style="width: 100%; max-width: 400px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
        </div>
        <div style="flex: 2; min-width: 300px;">
            <p>Halo! Saya <strong>Fakhri Afif</strong>, seseorang yang memiliki semangat tinggi dalam bidang <strong>pendidikan</strong> dan <strong>otomotif</strong>. Saya percaya bahwa ilmu pengetahuan adalah bekal penting untuk masa depan, dan saya senang berbagi pengetahuan dengan orang-orang di sekitar saya, terutama dalam dunia teknologi dan keterampilan praktis.</p>

            <p>Di bidang otomotif, saya sangat tertarik dengan kendaraan dan sistem mekanisnya, serta mengikuti perkembangan teknologi kendaraan terbaru. Saya juga memiliki pengalaman dalam memperbaiki perangkat elektronik seperti laptop dan handphone.</p>

            <p>Saya tinggal di <strong>Telaga Murni</strong> dan aktif dalam kegiatan edukatif, terutama untuk anak-anak. Saya percaya bahwa pendidikan yang baik dimulai dari lingkungan yang peduli dan suportif.</p>
        </div>
    </div>
<?= $this->endSection() ?>
