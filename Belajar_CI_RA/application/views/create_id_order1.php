<script>
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>

<!-- <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" /> -->


<div class="container">
    <ol class="breadcrumb">
        <li><a href="<?= base_url('user/Home') ?>">Home</a></li>
        <li class="active">Detail Pembelian</li>
    </ol>
    <div id="content" class="mb-invoice-3">
        <div class="mb-invoice-2">
            <div class="row-invoice-head">
                <div class="col-invoice-2">
                    <h4 style="margin-top: 8px;">ID ORDER</h4><br>
                    <h2 style="margin-left: 15px;" id="copy"><?= $id_order ?></h2>
                    <button class="btn btn-primary" style="margin: 0px 30px auto" onclick="copyToClipboard('#copy')">Copy ID</button>
                </div>
                <div class="col-invoice-2">
                    <button onClick="download_pdf()" class="btn btn-primary" style="margin: 0px 30px auto">Download</button>
                </div>
            </div>
            <div class="row-invoice-body">
                <div class="col-invoice-1 mb-invoice-1">
                    <h4>Nama Pembeli</h4>
                </div>
                <div class="col-invoice-2 mb-invoice-1">
                    <p>:</p>
                    <p>
                        <?= $order[0]['nama_order'] ?>
                    </p>
                </div>
            </div>
            <div class="row-invoice-body">
                <div class="col-invoice-1 mb-invoice-1">
                    <h4>Alamat</h4>
                </div>
                <div class="col-invoice-2 mb-invoice-1">
                    <p> : </p>
                    <p>
                        <?= $order[0]['alamat_order'] ?>
                    </p>
                </div>
            </div>
            <div class="row-invoice-body">
                <div class="col-invoice-1 mb-invoice-1">
                    <h4>Kecamatan</h4>
                </div>
                <div class="col-invoice-2 mb-invoice-1">
                    <p> : </p>
                    <p>
                        <?= $order[0]['nama_kecamatan'] ?>
                    </p>
                </div>
            </div>
            <div class="row-invoice-body">
                <div class="col-invoice-1 mb-invoice-1">
                    <h4>Kelurahan</h4>
                </div>
                <div class="col-invoice-2 mb-invoice-1">
                    <p> : </p>
                    <p>
                        <?= $order[0]['nama_kelurahan'] ?>
                    </p>
                </div>
            </div>
            <div class="row-invoice-body">
                <div class="col-invoice-1 mb-invoice-1">
                    <h4>Kurir</h4>
                </div>
                <div class="col-invoice-2 mb-invoice-1">
                    <p> : </p>
                    <p>
                        <?= $order[0]['kurir'] ?>
                    </p>
                </div>
            </div>
        </div>
        <h3 style="margin-bottom:18px">Detail Pemesanan</h3>
        <table class="table table-bordered" style="margin-bottom:50px">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Produk</th>
                    <th scope="col" class="text-center">Jumlah Produk</th>
                    <th scope="col" class="text-center">Harga Produk</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detail_order as $detail) : ?>
                    <tr>
                        <td class="text-center"><?= $detail['nama_produk'] ?></td>
                        <td class="text-center"><?= $detail['jumlah_produk'] ?></td>
                        <td class="text-center">Rp. <?= number_format($detail['harga'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach ?>
                <tr>
                    <th class="text-center">Ongkir</th>
                    <td class="text-center" colspan="2">Rp. <?= number_format($order[0]['ongkir'], 0, ',', '.')  ?></td>
                </tr>
                <tr>
                    <th class="text-center">Total Belanja</th>
                    <td class="text-center" colspan="2">Rp. <?= number_format($order[0]['total_order'], 0, ',', '.') ?></td>
                </tr>
            </tbody>
        </table>
        <h3 style="margin-bottom:18px">Lakukan Pembayaran Ke Rekening Berikut</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Bank</th>
                    <th scope="col" class="text-center">No Rekening</th>
                    <th scope="col" class="text-center">Nama</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bank as $bnk) : ?>
                    <tr>
                        <td class="text-center"><?= $bnk['jenis_bank'] ?></td>
                        <td class="text-center"><?= $bnk['no_rekening'] ?></td>
                        <td class="text-center"><?= $bnk['atas_nama_bank'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h5><span style="color:red">*</span>Lanjutkan ke konfirmasi Pembayaran dengan memasukkan kode ID Order</h5>
        <h5 style="margin-top:14px;"><span style="color:red;">*</span>Apabila pembayaran tidak dilakukan dalam 90 menit maka pesanan anda akan dihapus</h5>
    </div>
</div>

<script src="<?php echo base_url('assets/pdfjs/dist/jspdf.debug.js') ?>"></script>
<script src="<?php echo base_url('assets/pdfjs/libs/html2pdf.js') ?>"></script>
<script>
    function download_pdf() {
        // var doc = new jsPDF();
        // var specialElementHandlers = {
        //     '#editor': function (element, renderer) {
        //         return true;
        //     }
        // };

        // doc.fromHTML($('#content').html(), 15, 15);
        // doc.save('Blonjobu-Order-<?php echo $id_order ?>.pdf');
        var pdf = new jsPDF('p', 'pt', 'letter');
        pdf.addHTML($('#ElementYouWantToConvertToPdf')[0], function() {
            pdf.save('Blonjobu-Order-<?php echo $id_order ?>.pdf');
        });
    }

    var pdf = new jsPDF('p', 'pt', 'letter');

    pageHeight = pdf.internal.pageSize.height;

    // Before adding new content
    y = 500 // Height position of new content
    if (y >= pageHeight) {
        pdf.addPage();
        y = 0 // Restart height position
    }

    var canvas = pdf.canvas;

    // var width = 400;
    html2pdf(document.getElementById("print"), pdf, function(pdf) {

        pdf.save('Test.pdf');

        //var div = pdfument.createElement('pre');
        //div.innerText=pdf.output();
        //pdfument.body.appendChild(div);
    });


    //window.location = "http://www.facebook.com";
</script>

<script>
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>