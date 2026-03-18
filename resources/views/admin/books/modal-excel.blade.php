  <div class="modal fade" id="importModal" tabindex="-1">
      <div class="modal-dialog modal-sm">
          <div class="modal-content" style="border-radius: 8px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">

              <form action="{{ route('admin.books.import') }}" method="POST" enctype="multipart/form-data">
                  {{ csrf_field() }}

                  <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 8px 8px 0 0;">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title" style="font-weight: 700; color: #1e293b;">
                        <i class="fa fa-file-excel-o"></i> Import Data
                      </h4>
                  </div>

                  <div class="modal-body" style="padding: 20px;">
                      <div class="form-group mb-3">
                          <label style="font-weight: 600; color: #475569;">Upload File Excel</label>
                          <input type="file" name="file" class="form-control" style="padding: 10px; height: auto;" required>
                          <p class="help-block" style="font-size: 11px;">Format yang didukung: <strong>.xls</strong> atau <strong>.xlsx</strong></p>
                      </div>

                      <div class="alert alert-info" style="font-size: 12px; border-radius: 6px; margin-bottom: 0;">
                          <i class="fa fa-info-circle"></i> Pastikan format kolom sesuai dengan template yang tersedia.
                      </div>
                  </div>

                  <div class="modal-footer" style="background: #f8fafc; border-radius: 0 0 8px 8px;">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary" style="min-width: 100px;">
                          <i class="fa fa-upload"></i> Mulai Import
                      </button>
                  </div>
              </form>

          </div>
      </div>
  </div>