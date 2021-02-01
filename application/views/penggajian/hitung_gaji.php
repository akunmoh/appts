
    <header class="panel-heading">
        <h4 class="panel-title"><i class="fas fa-list-ul"></i> Hitung Gaji</h4>
        <div class="panel-btn">
            <button class="btn btn-default btn-sm modal-dismiss"><i class="fas fa-times"></i></button>
		</div>
    </header>

    <?=form_open('penggajian/hitung_gaji', array('class' => 'validate form-horizontal form-bordered')); ?>
    <div class="panel-body">
        <div class="invoice">
			<header class="clearfix">
				<div class="row">
					<div class="col-md-2">
						<div class="ib">
							<img src="<?php echo base_url('uploads/app_image/defualt.png'); ?>" width="100" />
						</div>
					</div>
                    <div class="col-xs-4 text-left">
						<h4 class="mt-none text-dark"><?=$pegawai['nama'];?></h4>
						<p class="mb-none">
							<span class="text-dark">Jabatan : </span> <span class="value"><?=$pegawai['nama_jabatan'];?></span>
						</p>
						<p class="mb-none">
							<span class="text-dark">Gaji Bulan : </span> <?= bulan($bulan);?> <?=$tahun;?>
						</p><br>
                        <p class="mb-none">
							<span class="text-dark">Pendidikan : </span> <?=$pegawai['pendidikan'];?>
						</p>
                        <p class="mb-none">
							<span class="text-dark">Jenis Kelamin : </span> <?=$pegawai['jenis_kelamin'];?>
						</p>
                    </div>
                    <div class="col-xs-6 text-right">
						<h4 class="mt-none text-dark">Info Kehadiran & Kasbon</h4>
						<p class="mb-none">
							<span class="text-dark">Masuk : </span> <?=$total_masuk;?>
						</p>
						<p class="mb-none">
							<span class="text-dark">Tidak Masuk : </span> <?=$total_alfa;?>
						</p>
                        <p class="mb-none">
							<span class="text-dark">Telat : </span> <?=$total_terlambat;?>
						</p><br>
                        <p class="mb-none">
							<span class="text-dark">Kasbon Bulan Ini : </span> <?=number_format($kasbon['total_kasbon'], 0, ',', '.');?>
						</p>
					</div>
				</div>
			</header>
        </div>

        <div class="row">
            <div class="col-md-6">
                <section class="panel panel-custom">
                    <header class="panel-heading panel-heading-custom">
                        <h4 class="panel-title">Tambahan/Bonus</h4>
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="tambahan[0][nama]"
                                    placeholder="Keterangan" />
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="tambahan form-control" name="tambahan[0][nominal]"
                                    placeholder="Nominal" />
                            </div>
                        </div>
                        <div id="add_new_tambahan"></div>
                        <button type="button" class="btn btn-default mt-md" onclick="addTambahanRows()">
                            <i class="fas fa-plus-circle"></i> Tambah
                        </button>
                    </div>
                </section>
            </div>

            <div class="col-md-6">
                <section class="panel panel-custom">
                    <header class="panel-heading panel-heading-custom">
                        <h4 class="panel-title">Potongan</h4>
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="potongan[0][nama]"
                                    placeholder="Keterangan" />
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="potongan form-control" name="potongan[0][nominal]"
                                    placeholder="Nominal" />
                            </div>
                        </div>
                        <div id="add_new_potongan"></div>
                        <button type="button" class="btn btn-default mt-md" onclick="addPotonganRows()">
                            <i class="fas fa-plus-circle"></i> Tambah
                        </button>
                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-6">
                <section class="panel panel-custom">
                    <header class="panel-heading panel-heading-custom">
                        <h4 class="panel-title">Detail Gaji</h4>
                    </header>
                    <div class="panel-body">
                        <table class="table text-dark tbr-middle">
                            <tbody>
                                <tr class="b-top-none">
                                    <td colspan="2">Gaji Pokok</td>
                                    <td class="text-left">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp </span>
                                            <input type="text" class="form-control" name="gaji_pokok" id="gaji_pokok" value="<?=$pegawai['gaji_pokok'];?>" required />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">Tambahan</td>
                                    <td class="text-left">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp </span>
                                            <input type="text" class="form-control" name="total_tambahan" readonly
                                                id="total_tambahan" value="0" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">Potongan</td>
                                    <td class="text-left">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rp </span>
                                            <input type="text" class="form-control" name="total_potongan" readonly
                                                id="total_potongan" value="0" />
                                        </div>
                                    </td>
                                </tr>

                                <tr class="h4">
                                    <td colspan="2">Total Gaji</td>
                                    <td class="text-left">
                                        <div class="input-group">
                                            <span
                                                class="input-group-addon">Rp </span>
                                            <input type="text" class="form-control" name="total_gaji" readonly
                                                id="total_gaji" value="<?=$pegawai['gaji_pokok'];?>" />
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <input type="hidden" name="pegawai_id" value="<?=$pegawai['id'];?>">
    <input type="hidden" name="bulan" value="<?=$bulan;?>">
    <input type="hidden" name="tahun" value="<?=$tahun;?>">
    <input type="hidden" name="status" value="dihitung">

    <footer class="panel-footer">
        <div class="row">
            <div class="col-md-offset-9 col-md-3">
                <button type="submit" name="submit" value="1" class="btn btn-default btn-block">
                    <i class="fas fa-plus-circle"></i> Simpan
                </button>
            </div>
        </div>
    </footer>
    <?php echo form_close(); ?>


<script type="text/javascript">
	var iTambahan = 1;
	function addTambahanRows() {
		var html_row = "";
		html_row += '<div class="row" id="al_row_' + iTambahan + '"><div class="col-md-6 mt-md">';
		html_row += '<input class="form-control" name="tambahan[' + iTambahan + '][nama]" placeholder="Keterangan" type="text">';
		html_row += '</div>';
		html_row += '<div class="col-md-4 mt-md"> <input type="number" class="tambahan form-control" name="tambahan[' + iTambahan + '][nominal]" placeholder="Nominal"></div>';
		html_row += '<div class="col-md-2 mt-md text-right"><button type="button" class="btn btn-danger" onclick="deleteAllowancRow(' + iTambahan + ')"><i class="fas fa-times"></i> </button></div></div>';
		$("#add_new_tambahan").append(html_row);
		iTambahan++;
	}

    function deleteAllowancRow(id) {
        $("#al_row_" + id).remove();
      	totalCalculate();
    }
	
	var iPotongan = 1;
	function addPotonganRows() {
		var html_row = "";
		html_row += '<div class="row" id="de_row_' + iPotongan + '"><div class="col-md-6 mt-md">';
		html_row += '<input class="form-control" name="potongan[' + iPotongan + '][nama]" placeholder="Keterangan" type="text">';
		html_row += '</div><div class="col-md-4 mt-md"> <input type="number" class="potongan form-control" name="potongan[' + iPotongan + '][nominal]" placeholder="Nominal"></div>';
		html_row += '<div class="col-md-2 mt-md text-right"><button type="button" class="btn btn-danger" onclick="deletePotonganRow(' + iPotongan + ')"><i class="fas fa-times"></i> </button></div></div>';
		$("#add_new_potongan").append(html_row);
		iPotongan++;
	}

    function deletePotonganRow(id) {
        $("#de_row_" + id).remove();
        totalCalculate();
    }
	
    $(document).on( "change", function () {
		totalCalculate();
    });
	
	function totalCalculate() {
        var total_tambahan = 0;
        var total_potongan = 0;
        $(".tambahan").each(function () {
            total_tambahan += read_number($(this).val());
        });

        $(".potongan").each(function () {
            total_potongan += read_number($(this).val());
        });

        $("#total_tambahan").val(total_tambahan);
        $("#total_potongan").val(total_potongan);

		var basic = read_number($('#gaji_pokok').val());
        var net_amount = (basic + total_tambahan) - total_potongan;

        $("#total_gaji").val(net_amount);
	}
</script>