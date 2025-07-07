<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php if ($artikel) : ?>
    <?php foreach ($artikel as $row) : ?>
        <article class="entry">
            <h2>
                <a href="<?= base_url('/artikel/' . $row['slug']); ?>">
                    <?= $row['judul']; ?>
                </a>
            </h2>

            <!-- Tampilkan nama kategori -->
            <p><strong>Kategori:</strong> <?= $row['nama_kategori']; ?></p>

            <img src="<?= base_url('/gambar/' . $row['gambar']); ?>" alt="<?= esc($row['judul']); ?>" class="artikel-gambar">

            <p><?= substr($row['isi'], 0, 200); ?></p>
        </article>
        <hr class="divider" />
    <?php endforeach; ?>
<?php else : ?>
    <article class="entry">
        <h2>Belum ada data.</h2>
    </article>
<?php endif; ?>

<?= $this->endSection() ?>
