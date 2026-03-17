<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="userForm">

                <input type="hidden" id="user_id" name="user_id">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">User</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                        <small class="text-muted">Kosongkan jika tidak diubah</small>
                    </div>

                    <div class="form-group">
                        <label>Role</label>

                        <div id="roles-wrapper">

                            <div class="role-item mb-2">
                                <select name="role_id[]" class="form-control">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">
                                            {{ $role->display_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <button type="button" class="btn btn-sm btn-success mt-2" id="addRole">
                            + Tambah Role
                        </button>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" id="btnSaveUser" class="btn btn-primary">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
