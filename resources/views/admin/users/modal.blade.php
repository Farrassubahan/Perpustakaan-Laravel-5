<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 8px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">

            <form id="userForm">
                <input type="hidden" id="user_id" name="user_id">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 8px 8px 0 0;">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title" id="userModalLabel" style="font-weight: 700; color: #1e293b;">
                        <i class="fa fa-user"></i> Form Data User
                    </h4>
                </div>

                <div class="modal-body" style="padding: 25px;">
                    <div class="form-group mb-3">
                        <label class="control-label" style="font-weight: 600; color: #475569;">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Masukkan nama lengkap...">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="control-label" style="font-weight: 600; color: #475569;">Alamat Email</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" name="email" id="email" class="form-control" placeholder="example@mail.com">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="control-label" style="font-weight: 600; color: #475569;">Password</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••">
                        </div>
                        <p class="help-block" style="font-size: 11px; margin-top: 5px;">* Kosongkan jika tidak ingin mengubah password</p>
                    </div>

                    <div class="form-group mb-3">
                        <label class="control-label" style="font-weight: 600; color: #475569;">Hak Akses (Role)</label>
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
                        <button type="button" class="btn btn-sm btn-default mt-2" id="addRole" style="border-style: dashed; width: 100%;">
                            <i class="fa fa-plus"></i> Tambah Role Lainnya
                        </button>
                    </div>
                </div>

                <div class="modal-footer" style="background: #f8fafc; border-radius: 0 0 8px 8px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" id="btnSaveUser" class="btn btn-primary shadow-sm" style="min-width: 120px;">
                        <i class="fa fa-save"></i> Simpan Data
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

