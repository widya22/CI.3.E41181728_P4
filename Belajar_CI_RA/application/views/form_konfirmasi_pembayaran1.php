<div class="container">
  <ol class="breadcrumb">
    <li><a href="<?= base_url('user/Home') ?>">Home</a></li>
    <li class="active">Form Konfirmasi Pembayaran</li>
  </ol>
  <div class="row mb-invoice-3">
    <div class="col-md-12">
      <h3 style="margin-bottom:10px">ID Order : <?= $data_order[0]['id_order'] ?></h3>
      <h4 style="margin-bottom:10px">Informasi Pemesanan</h4>
      <table class="table ">
        <tr>
          <td>Nama Penerima</td>
          <td><?= $data_order[0]['nama_order'] ?></td>
        </tr>
        <tr>
          <td>No Hp</td>
          <td><?= $data_order[0]['tlp_order'] ?></td>
        </tr>
        <tr>
          <td>Alamat Penerima</td>
          <td><?= $data_order[0]['alamat_order'] ?></td>
        </tr>
        <tr>
          <td>Kecamatan</td>
          <td><?= $data_order[0]['nama_kecamatan'] ?></td>
        </tr>
        <tr>
          <td>Kelurahan</td>
          <td><?= $data_order[0]['nama_kelurahan'] ?></td>
        </tr>
        <tr>
          <td>Status Pembayaran</td>
          <td><?= $status_order ?></td>
        </tr>
        <tr>
          <td colspan=2>
            <?php if ($data_order[0]['status_order'] == 4) : ?>
              <a id="konfirmasi_barang" type="button" class="btn btn-block btn-success">Barang Sudah Sampai</a>
            <?php endif; ?>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row mb-invoice-3">
    <div class="col-md-12">
      <h3 style="margin-bottom:10px">Detail Barang</h3>
      <div class="table-responsive">
        <table class="table ">
          <thead>
            <tr>
              <th scope="col">Nama Barang</th>
              <th scope="col">Foto Barang</th>
              <th scope="col">Jumlah</th>
              <th scope="col">Harga</th>
              <?php if ($data_order[0]['status_order'] == 5) : ?>
                <th scope="col">Opsi</th>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data_penjual as $penjual) : foreach ($penjual as $produk) : ?>
                <tr>
                  <td><?= $produk['nama_produk'] ?></td>
                  <td><img src="<?php echo base_url() ?>assets/img/produk_penjual/<?= $produk['foto_produk1'] ?>" alt="img" width="180" height="180"></td>
                  <td><?= number_format($produk['jumlah_produk'], 0, ',', '.') ?></td>
                  <td>Rp. <?= number_format($produk['harga'], 0, ',', '.') ?></td>
                  <td>
                    <?php if ($data_order[0]['status_order'] == 5) : ?>
                      <?php if ($produk['status_detail_komplain'] == 1) : ?>
                        <a href="<?= base_url("user/order/komplain_barang/" . $produk['id_detail_order']) ?>" class="btn btn-success">Detail Komplain Barang</a>
                      <?php else : ?>
                        <a href="<?= base_url('user/order/komplain_barang/' . $produk['id_detail_order']) ?>" class="btn btn-success">Komplain</a>
                    <?php endif;
                    endif; ?>
                  </td>
                </tr>
            <?php endforeach;
            endforeach; ?>
            <tr>
              <th colspan=2 scope="col">Ongkir</th>
              <td></td>
              <td colspan=2>Rp. <?= number_format($data_order[0]['ongkir'], 0, ',', '.') ?></td>
            </tr>
            <tr>
              <td colspan=2>Total</td>
              <td><?= number_format($data_order[0]['jumlah_order'], 0, ',', '.') ?></td>
              <td colspan=2>Rp. <?= number_format($data_order[0]['total_order'], 0, ',', '.') ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php if ($data_order[0]['status_order'] == 1) : ?>
    <form action="<?= base_url('user/order/form_konfirmasi_pembayaran') ?>" method="POST" enctype="multipart/form-data">
      <div class="row mb-invoice-3">
        <div class="col-md-6">
          <h3 class="mb-invoice-2">Form Konfirmasi Pembayaran</h3>
          <div class="form-group">
            <label>Tanggal Transfer</label>
            <input type="date" name="tanggal_transfer" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Nama Pemilik Rekening</label>
            <input type="text" name="nama_rekening" placeholder="nama rekening Anda" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Nomor Rekening</label>
            <input type="number" name="no_rekening" placeholder="no rekening Anda" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Telah Ditransfer Ke</label>
            <select name="bank_transfer" class="form-control" required>
              <option value="" hidden option value>pilih bank</option>
              <?php foreach ($data_bank as $bank) : ?>
                <option value="<?= $bank['jenis_bank'] ?>"><?= $bank['jenis_bank'] ?><br> (<?= $bank['no_rekening'] ?>)</option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label>Total Transfer</label>
            <input type="number" min="<?= $data_order[0]['total_order'] ?>" name="total_transfer" placeholder="<?= number_format($data_order[0]['total_order'], 0, ',', '.') ?>" class="form-control" required>
          </div>
          <div>
            <label>Bukti Transfer</label>

            <input type="file" name="bukti" id="bukti" class="form-controll" value="0" accept="image/*" onchange="readURL('btk',this);" required><br>
            <img id="btk" style="display: none;" src="#" alt="your image" />

            <br><br>
          </div>
          <div class="form-group">
            <input type="hidden" name="id_order" value="<?php echo $data_order[0]['id_order'] ?>">
            <button class="btn btn-block btn-success" type="submit">Kirim</button>
          </div>
        </div>
      </div>
    </form>
  <?php endif; ?>
</div>

<script>
  function readURL(id, input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#' + id)
          .attr('src', e.target.result)
          .width(200)
          .height(250);
      };

      reader.readAsDataURL(input.files[0]);
      $("#" + id).show();
    }
  }
</script>
<script>
  $('#konfirmasi_barang').click(function(event) {
    $.ajax({
      url: '<?= base_url() . 'user/order/konfirmasi_barang/' . $data_order[0]['id_order'] ?>',
      type: 'POST',
      success: function(result) {
        location.reload();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log('Error get data from ajax');
      }
    })
  })
</script>