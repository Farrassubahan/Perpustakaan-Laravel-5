  <!-- MODAL DETAIL -->
  <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog">
      <div class="modal-dialog">
          <div class="modal-content">

              <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal">
                      &times;
                  </button>

                  <h4 class="modal-title">Detail Buku</h4>

              </div>

              <div class="modal-body">

                  <table class="table table-bordered">

                      <tr>
                          <th width="150">Kategori</th>
                          <td id="detail_category"></td>
                      </tr>

                      <tr>
                          <th>Judul</th>
                          <td id="detail_title"></td>
                      </tr>

                      <tr>
                          <th>Author</th>
                          <td id="detail_author"></td>
                      </tr>

                      <tr>
                          <th>Publisher</th>
                          <td id="detail_publisher"></td>
                      </tr>

                      <tr>
                          <th>Tahun</th>
                          <td id="detail_year"></td>
                      </tr>

                      <tr>
                          <th>Stock</th>
                          <td id="detail_stock"></td>
                      </tr>

                  </table>

              </div>

              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 6px;">
                      Tutup
                  </button>
                  <a href="#" id="btnOpenLoanModal" class="btn"
                      style="background-color: #D65F55; color: white; border-radius: 6px; padding: 6px 20px; text-decoration: none;">
                      Pinjam Buku
                  </a>
              </div>

          </div>
      </div>
  </div>
