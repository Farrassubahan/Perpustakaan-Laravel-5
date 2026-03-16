  <!-- Modal Import Excel -->
        <div class="modal fade" id="importModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form action="{{ route('admin.books.import') }}" method="POST" enctype="multipart/form-data">

                        {{ csrf_field() }}

                        <div class="modal-header">
                            <h4 class="modal-title">Import Data Buku</h4>
                        </div>

                        <div class="modal-body">

                            <div class="form-group">
                                <label>Upload File Excel</label>
                                <input type="file" name="file" class="form-control" required>
                                <small>Format: .xls atau .xlsx</small>
                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Batal
                            </button>

                            <button type="submit" class="btn btn-success">
                                Import
                            </button>

                        </div>

                    </form>

                </div>
            </div>
        </div>