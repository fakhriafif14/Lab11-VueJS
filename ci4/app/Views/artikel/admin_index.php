<?= $this->include('template/admin_header'); ?>

<!-- Form Pencarian -->
<form method="get" class="form-search mb-3">
    <input type="text" name="q" value="<?= $q; ?>" placeholder="Cari data" class="form-control d-inline-block w-auto mr-2">
    <input type="submit" value="Cari" class="btn btn-primary">
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($artikel): ?>
            <?php foreach ($artikel as $row): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td>
                        <b><?= $row['judul']; ?></b>
                        <p><small><?= substr($row['isi'], 0, 50); ?></small></p>
                    </td>
                    <td><?= $row['status']; ?></td>
                    <td>
                        <a class="btn btn-sm btn-info" href="<?= base_url('/admin/artikel/edit/' . $row['id']); ?>">Ubah</a>
                        <a class="btn btn-sm btn-danger" onclick="return confirm('Yakin menghapus data?');" href="<?= base_url('/admin/artikel/delete/' . $row['id']); ?>">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center">Belum ada data.</td>
            </tr>
        <?php endif; ?>
    </tbody>
    <tfoot>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </tfoot>
</table>

<!-- Pagination -->
<div class="pagination-container">
    <?= $pager->only(['q'])->links('default', 'custom_pagination'); ?>
</div>

<?= $this->include('template/admin_footer'); ?>
