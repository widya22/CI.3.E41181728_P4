<div class="single-sec">
	<div class="container">
		<ol class="breadcrumb">
			<li><a href="<?= base_url('user/Home') ?>">Home</a></li>
			<li class="active">Detail Produk</li>
		</ol>
		<!-- start content -->
		<div class="col-md-12 det" style="margin-bottom: 80px;">
			<div class="single_left">
				<div class="grid images_3_of_2">
					<ul id="etalage">
						<li style="width: 300px;">
							<a href="">
								<?php if ($detail_produk[0]['foto_produk1'] == null) : ?>

								<?php else : ?>
									<img class="etalage_thumb_image" style="width:300px;" src="<?= base_url() ?>assets/img/produk_penjual/<?= $detail_produk[0]['foto_produk1'] ?>" class="img-responsive" />
									<img class="etalage_source_image" style="width:300px;" src="<?= base_url() ?>assets/img/produk_penjual/<?= $detail_produk[0]['foto_produk1'] ?>" class="img-responsive" title="" />
								<?php endif; ?>
							</a>
						</li>
						<li style="width: 300px;">
							<?php if ($detail_produk[0]['foto_produk2'] == null) : ?>

							<?php else : ?>
								<img class="etalage_thumb_image" style="width: contain; height: 250px; object-fit: cover;" src="<?= base_url() ?>assets/img/produk_penjual/<?= $detail_produk[0]['foto_produk2'] ?>" class="img-responsive" />
								<img class="etalage_source_image" style="width:300px;" src="<?= base_url() ?>assets/img/produk_penjual/<?= $detail_produk[0]['foto_produk2'] ?>" class="img-responsive" title="" />
							<?php endif; ?>
						<li style="width: 300px;">
							<?php if ($detail_produk[0]['foto_produk3'] == null) : ?>

							<?php else : ?>
								<img class="etalage_thumb_image" style="width: contain; height: 250px; object-fit: cover;" src="<?= base_url() ?>assets/img/produk_penjual/<?= $detail_produk[0]['foto_produk3'] ?>" class="img-responsive" />
								<img class="etalage_source_image" style="width: contain; height: 250px; object-fit: cover;" src="<?= base_url() ?>assets/img/produk_penjual/<?= $detail_produk[0]['foto_produk3'] ?>" class="img-responsive" title="" />
							<?php endif; ?>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="single-right">
				<h3><?= $detail_produk[0]['nama_produk'] ?></h3>
				<div class="id">
					<h4>ID: <?= $detail_produk[0]['id_produk'] ?></h4>
				</div>
				<div class="cost" style="margin-top: 20px;">
					<div class="prdt-cost">
						<ul>
							<li>
								<h4>Harga: </h4>
							</li>
							<li class="active">Rp. <?= number_format($detail_produk[0]['harga'], 0, ',', '.') ?></li>
							<form method="POST" action="<?= base_url() ?>user/Home/keranjang_belanja">
								<input type="hidden" value="1" name="quantity">
								<input type="hidden" name="harga" value="<?php echo $detail_produk[0]['harga'] ?>">
								<input type="hidden" name="id_produk" value="<?php echo $detail_produk[0]['id_produk'] ?>">
								<?php if ($detail_produk[0]['jumlah_stok'] <= 0) : ?>
									<button type="submit" disabled>Maaf produk sudah habis</button>
								<?php else : ?>
									<button type="submit">Tambah ke keranjang</button>
								<?php endif; ?>
							</form>
						</ul>
					</div>

					<div class="clearfix"></div>
				</div>
				<div class="single-bottom1">
					<h6>Details</h6>
					<p class="prod-desc"><?= $detail_produk[0]['deskripsi'] ?></p>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
</div>