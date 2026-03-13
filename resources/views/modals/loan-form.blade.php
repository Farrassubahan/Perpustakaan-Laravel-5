<div class="modal fade" id="modalLoan" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>

                <h4 class="modal-title">Form Peminjaman Buku</h4>

            </div>

            <div class="modal-body">

                <input type="hidden" id="loan_book_id">

                <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" id="loan_book_title" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label>Jumlah Pinjam</label>
                    <input type="number" id="loan_qty" class="form-control" value="1" min="1"
                        max="5">
                </div>

                <div class="form-group">
                    <label>Tanggal Pengembalian</label>
                    <input type="date" id="return_date" class="form-control">
                </div>

            </div>

            <div class="modal-footer">

                <button class="btn btn-default" data-dismiss="modal">
                    Batal
                </button>

                <button class="btn btn-primary" id="btnSubmitLoan">
                    Ajukan Peminjaman
                </button>

            </div>

        </div>
    </div>
</div>
