<div class="modal fade" id="modalBooks" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: var(--border-radius); overflow: hidden;">

            <div class="modal-header" style="background: #fff; border-bottom: 1px solid var(--border-color); padding: 20px;">
                <button type="button" class="close" data-dismiss="modal" id="closeModalBooks">
                    &times;
                </button>
                <h4 class="modal-title" style="font-weight: 700; color: var(--text-main);">
                    <i class="fa fa-book" style="color: var(--primary-color);"></i> Data Koleksi Buku
                </h4>
            </div>

            <div class="modal-body" style="padding: 24px;">
                <div class="table-responsive">
                    <table class="table table-hover" id="tableBooks" width="100%">
                        <thead>
                            <tr>
                                <th width="50">No</th>
                                <th>Judul</th>
                                <th>Author</th>
                                <th>Kategori</th>
                                <th width="80">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid var(--border-color); padding: 15px 24px;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px;">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>
