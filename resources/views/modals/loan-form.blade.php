<div class="modal fade" id="modalLoan" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: var(--border-radius); overflow: hidden;">

            <div class="modal-header" style="background: #fff; border-bottom: 1px solid var(--border-color); padding: 20px;">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h4 class="modal-title" style="font-weight: 700; color: var(--text-main);">
                    <i class="fa fa-edit" style="color: var(--primary-color);"></i> Form Peminjaman Buku
                </h4>
            </div>

            <div class="modal-body" style="padding: 24px;">

                <input type="hidden" id="loan_book_id">

                <div class="form-group mb-4">
                    <label style="color: var(--text-muted); font-weight: 600; margin-bottom: 8px;">Judul Buku</label>
                    <input type="text" id="loan_book_title" class="form-control" readonly 
                        style="background-color: #f1f5f9; border-radius: 8px; border: 1px solid var(--border-color); font-weight: 600;">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label style="color: var(--text-muted); font-weight: 600; margin-bottom: 8px;">Jumlah Pinjam</label>
                            <input type="number" id="loan_qty" class="form-control" value="1" min="1" max="5"
                                style="border-radius: 8px; border: 1px solid var(--border-color);">
                            <small class="text-muted">Maksimal 5 buku</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label style="color: var(--text-muted); font-weight: 600; margin-bottom: 8px;">Tanggal Pengembalian</label>
                            <input type="date" id="return_date" class="form-control"
                                style="border-radius: 8px; border: 1px solid var(--border-color);">
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid var(--border-color); padding: 15px 24px;">
                <button class="btn btn-default" data-dismiss="modal" style="border-radius: 8px;">
                    Batal
                </button>
                <button class="btn btn-primary" id="btnSubmitLoan" 
                    style="border-radius: 8px; padding: 8px 24px; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">
                    <i class="fa fa-check-circle"></i> Ajukan Peminjaman
                </button>
            </div>

        </div>
    </div>
</div>
