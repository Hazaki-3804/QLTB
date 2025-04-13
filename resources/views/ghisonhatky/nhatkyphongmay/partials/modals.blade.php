<!-- Modal Cập nhật tình trạng thiết bị -->
<div class="modal fade" id="modalUpdateStatus" tabindex="-1" role="dialog" aria-labelledby="modalUpdateStatusLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 800px; margin-left: auto; margin-right: auto;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" style="font-size: 20px;" id="editModalLabel">Cập nhật tình trạng thiết bị</h3>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Tên thiết bị</label>
                        <div class="col-sm-8">
                            <input type="text" name="tentb" id="edit-tentb" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Mô tả</label>
                        <div class="col-sm-8">
                            <textarea rows="3" type="text" name="mota" id="edit-mota" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Ghi chú</label>
                        <div class="col-sm-8">
                            <textarea rows="5" type="text" name="ghichu" id="edit-ghichu" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Tình trạng</label>
                        <div class="col-sm-8">
                            <select name="tinhtrang" id="edit-tinhtrang" class="form-control" required>
                                <option value="1">Đang sử dụng</option>
                                <option value="2">Hư hỏng</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Sửa -->
<div class="modal fade" id="editPMModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h3 class="modal-title" id="editModalLabel">Cập nhật</h3>
                <form id="editForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Phòng máy -->
                        <div class="form-group mb-3">
                            <label for="edit-phong" class="form-label fw-bold">Phòng máy</label>
                            <input type="text" disabled id="edit-phong" name="phong" class="form-control" required>
                        </div>

                        <div class="row mb-3">
                            <!-- Giờ vào -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit-giovao" class="form-label fw-bold">Giờ vào</label>
                                    <input type="time" id="edit-giovao" name="giovao" class="form-control" required>
                                </div>
                            </div>

                            <!-- Giờ ra -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit-giora" class="form-label fw-bold">Giờ ra</label>
                                    <input type="time" id="edit-giora" name="giora" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <!-- Mục đích sử dụng -->
                        <div class="form-group mb-3">
                            <label for="edit-mucdichsd" class="form-label fw-bold">Mục đích sử dụng</label>
                            <textarea name="mucdichsd" id="edit-mucdichsd" class="form-control" rows="3"></textarea>
                        </div>

                        <!-- Tình trạng trước -->
                        <div class="form-group mb-3">
                            <label for="edit-tinhtrangtruoc" class="form-label fw-bold">Tình trạng trước khi sử dụng</label>
                            <textarea name="tinhtrangtruoc" id="edit-tinhtrangtruoc" class="form-control" rows="3"></textarea>
                        </div>

                        <!-- Tình trạng sau -->
                        <div class="form-group mb-3">
                            <label for="edit-tinhtrangsau" class="form-label fw-bold">Tình trạng sau khi sử dụng</label>
                            <textarea name="tinhtrangsau" id="edit-tinhtrangsau" class="form-control" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>