<div class="single-sec">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="<?= base_url('user/Home') ?>">Home</a></li>
            <li class="active">Checkout</li>
        </ol>
        <form action="<?= base_url('user/order/simpan') ?>" method="post">
            <div class="col-md-12 det" style="margin-bottom: 80px;">
                <div class="table-responsive">
                    <div class="single-right">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Produk</th>
                                    <th scope="col" class="text-center">Jumlah Produk</th>
                                    <th scope="col" class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart as $keranjang) : ?>
                                    <tr>
                                        <td class="text-center"><?= $keranjang['nama_produk'] ?></td>
                                        <td class="text-center"><?= $keranjang['jumlah_produk'] ?> item</td>
                                        <td class="text-center">Rp<?= number_format($keranjang['subtotal_belanja'], 0, ',', '.') ?>,00</td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <th scope="col" class="text-center">Total Belanja</th>
                                    <td class="text-center"><?= $total[0]['total_jumlah'] ?> item</td>
                                    <td class="text-center">Rp<?= number_format($total[0]['total_harga'], 0, ',', '.') ?>,00</td>
                                </tr>
                                <tr>
                                    <td colspan=3>
                                        <input name="ongkir" type="hidden" value="">
                                        <input name="kurir" type="hidden" value="">
                                        <input name="total_harga" type="hidden" value="<?= $total[0]['total_harga'] ?>">
                                        <input name="total_jumlah" type="hidden" value="<?= $total[0]['total_jumlah'] ?>">
                                        <button id="btn_beli" type="submit" class="btn btn-success btn-block">Beli</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="single_left">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Nama Lengkap</label>
                            <input name="nama-lengkap" type="text" class="form-control" placeholder="nama lengkap" required oninvalid="this.setCustomValidity('Nama Lengkap belum diisi')" oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>No Hp</label>
                            <input name="no-hp" type="number" class="form-control" placeholder="no hp" required oninvalid="this.setCustomValidity('Nomor HP belum diisi')" oninput="setCustomValidity('')">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Alamat Lengkap</label>
                            <textarea name="alamat-lengkap" class="form-control" placeholder="alamat lengkap" required oninvalid="this.setCustomValidity('Alamat Lengkap belum diisi')" oninput="setCustomValidity('')"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Pilih jam pengiriman</label>
                            <select name="jam_kirim" id="jam_kirim" class="form-control" required oninvalid="this.setCustomValidity('Jam Pengiriman belum dipilih')" oninput="setCustomValidity('')">
                                <option value="" disabled selected hidden>pilih jam kirim</option>
                                <?php foreach ($jam_kirim as $jam) : ?>
                                    <?php $jam_kirim = strtotime($jam['jam_kirim']); ?>
                                    <option value=" <?= date('h:i A', $jam_kirim); ?>">
                                        <?= date('h:i A', $jam_kirim); ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Pilih Kota</label>
                            <select name="kota_order" id="kota" class="form-control" required oninvalid="this.setCustomValidity('Kota belum dipilih')" oninput="setCustomValidity('')">
                                <option value="" disabled selected hidden>pilih kota/kab</option>
                                <?php foreach ($this->dropdown->kota() as $row) : ?>
                                    <option value="<?php echo $row['id_kota']; ?>">
                                        <?php echo $row['nama_kota']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="form-control" required oninvalid="this.setCustomValidity('Kecamatan belum dipilih')" oninput="setCustomValidity('')">
                                <option value="" disabled selected hidden>pilih kecamatan</option>
                                <?php foreach ($this->dropdown->kecamatan() as $row) : ?>
                                    <option id="kecamatan" class="<?php echo $row['id_kota']; ?>" value="<?php echo $row['id_kecamatan']; ?>">
                                        <?php echo $row['nama_kecamatan']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Kelurahan</label>
                            <select name="kelurahan" id="kelurahan" onchange="hasil()" class="form-control" required oninvalid="this.setCustomValidity('Kelurahan belum dipilih')" oninput="setCustomValidity('')">
                                <option value="" disabled selected hidden>pilih kelurahan</option>
                                <?php foreach ($this->dropdown->kelurahan() as $row) : ?>
                                    <option id="kelurahan" class="<?php echo $row['id_kecamatan']; ?>" value="<?php echo $row['id_kelurahan']; ?>">
                                        <?php echo $row['nama_kelurahan']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="from-row">
                            <div style="text-align: justify;" class="form-group col-md-12" id="kurir_kirim"></div>
                        </div>
                        <div class="form-row">
                            <select style="visibility: hidden;" id="kurir" onchange="view_kurir()" class="form-control" required>
                                <?php foreach ($this->dropdown->daerah_kirim() as $row) : ?>
                                    <option id="kurir" class="<?php echo $row['id_kel']; ?>" value="Produk dikirim oleh kurir <?php echo $row['kurir']; ?> dengan ongkir Rp<?php echo number_format($row['ongkir'], 0, (','), ('.'))  ?>,00">
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <script src="<?php echo base_url('assets/jquery/jquery-1.12.0.js'); ?>"></script>
                    <script src="<?php echo base_url('assets/jquery/jquery.chained.js'); ?>"></script>
                    <script src="<?php echo base_url('assets/bootstrap/dist/js/bootstrap.js'); ?>"></script>

                    <script type="text/javascript">
                        $("#kecamatan").chained("#kota");
                        $("#kelurahan").chained("#kecamatan");
                        $("#kurir").chained("#kelurahan");
                    </script>
                    <script>
                        function view_kurir() {
                            if (document.getElementById("kelurahan").value != "") {
                                var a = document.getElementById("kurir").value;
                                var b = "Maaf! Pengiriman belum tersedia untuk lokasi Anda";

                                if (a != "") {
                                    $('#kurir_kirim').html(a);
                                    // document.getElementById("kurir_kirim").value = a;
                                } else {
                                    $('#kurir_kirim').html(b);
                                    // document.getElementById("kurir_kirim").value = b;
                                    document.getElementById("btn_beli").disabled = true;
                                }
                            } else {
                                document.getElementById("kurir_kirim").value = null;
                                document.getElementById("btn_beli").disabled = false;
                            }
                        }
                    </script>
                </div>
                <div class="clearfix"></div>
            </div>
        </form>
    </div>
    <div class="clearfix"></div>
</div>