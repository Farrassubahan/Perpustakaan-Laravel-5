  <!-- MODAL DETAIL -->
  <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content" style="border-radius: var(--border-radius); overflow: hidden;">

              <div class="modal-header" style="background: #fff; border-bottom: 1px solid var(--border-color); padding: 20px;">
                  <button type="button" class="close" data-dismiss="modal">
                      &times;
                  </button>
                  <h4 class="modal-title" style="font-weight: 700; color: var(--text-main);">
                      <i class="fa fa-info-circle" style="color: var(--primary-color);"></i> Detail Informasi Buku
                  </h4>
              </div>

              <div class="modal-body" style="padding: 24px;">
                  <div class="table-responsive">
                    <table class="table no-border-top">
                        <tr>
                            <th width="140" style="border-top: none; color: var(--text-muted);"><i class="fa fa-tag"></i> Kategori</th>
                            <td style="border-top: none; font-weight: 600;" id="detail_category"></td>
                        </tr>
                        <tr>
                            <th style="color: var(--text-muted);"><i class="fa fa-book"></i> Judul</th>
                            <td style="font-weight: 600;" id="detail_title"></td>
                        </tr>
                        <tr>
                            <th style="color: var(--text-muted);"><i class="fa fa-user"></i> Author</th>
                            <td id="detail_author"></td>
                        </tr>
                        <tr>
                            <th style="color: var(--text-muted);"><i class="fa fa-building"></i> Publisher</th>
                            <td id="detail_publisher"></td>
                        </tr>
                        <tr>
                            <th style="color: var(--text-muted);"><i class="fa fa-calendar"></i> Tahun</th>
                            <td id="detail_year"></td>
                        </tr>
                        <tr>
                            <th style="color: var(--text-muted);"><i class="fa fa-archive"></i> Stock</th>
                            <td id="detail_stock"></td>
                        </tr>
                    </table>
                  </div>
              </div>

              <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid var(--border-color); padding: 15px 24px;">
                  <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px;">
                      Tutup
                  </button>
                  <a href="#" id="btnOpenLoanModal" class="btn btn-primary"
                      style="border-radius: 8px; padding: 8px 24px; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">
                      <i class="fa fa-bookmark"></i> Pinjam Buku
                  </a>
              </div>

          </div>
      </div>
  </div>

  <style>
    .no-border-top tr:first-child th, 
    .no-border-top tr:first-child td {
        border-top: none !important;
    }
    .modal-body table th {
        font-weight: 500;
        background-color: transparent !important;
        text-transform: none !important;
        font-size: 0.95rem !important;
        letter-spacing: normal !important;
    }
  </style>
