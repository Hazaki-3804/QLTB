@extends('layouts.app')
@section('title','Quản lý tài khoản')
@section('css')
<link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" style="padding-left: 0;">
            <div class="ibox float-e-margins">
                <div class="ibox-title my-ibox-title">
                    <h2>Danh sách tài khoản</h2>
                    <button class="btn btn-success" data-toggle="modal" data-target="#addTKModal"><i class="fa fa-plus"></i> Thêm tài khoản</button>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-taikhoan">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Họ tên</th>
                                    <th>CCCD</th>
                                    <th>Email</th>
                                    <th>Chức vụ</th>
                                    <th>Loại tài khoản</th>
                                    <th>Đơn vị</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taikhoans as $taikhoan)
                                <tr class="gradeX">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $taikhoan->hoten }}</td>
                                    <td>{{ $taikhoan->cmnd }}</td>
                                    <td>{{ $taikhoan->email }}</td>
                                    <td>{{ $taikhoan->chucvu }}</td>
                                    <td>{{ $taikhoan->loaitaikhoan->tenloai ?? '' }}</td>
                                    <td>{{ $taikhoan->donvi->tendonvi ?? '' }}</td>
                                    <td class="text-center" style="display: flex; justify-content: center; align-items: center; gap: 20px;">
                                        <button class="btn btn-warning btn-sm edit-btn"
                                            data-tooltip="Cập nhật"
                                            data-id="{{ $taikhoan->id }}"
                                            data-toggle="modal"
                                            data-target="#editTKModal">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm delete-btn"
                                            data-tooltip="Xóa"
                                            data-id="{{ $taikhoan->id }}"
                                            data-toggle="modal"
                                            data-target="#deleteTKModal">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('quanlytaikhoan.taikhoan.partials.modals')
@endsection
@section('js')
<script src="js/plugins/dataTables/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        // Xử lý nút sửa tài khoản
        $('.edit-btn').click(function() {
            var id = $(this).data('id');

            // Lấy thông tin đơn vị qua AJAX
            $.ajax({
                url: '{{ route("taikhoan.edit", ":id") }}'.replace(':id', id),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Điền thông tin vào form
                    $('#edit_hoten').val(response.taikhoan.hoten);
                    $('#edit_cmnd').val(response.taikhoan.cmnd);
                    $('#edit_email').val(response.taikhoan.email);
                    $('#edit_chucvu').val(response.taikhoan.chucvu);
                    $('#edit_maloaitk').val(response.taikhoan.maloaitk);
                    $('#edit_madonvi').val(response.taikhoan.madonvi);
                    // Cập nhật action của form
                    $('#editForm').attr('action', '{{ route("taikhoan.update", ":id") }}'.replace(':id', id));
                },
                error: function(xhr) {
                    showToast('error', 'Đã xảy ra lỗi khi lấy thông tin tài khoản.');
                }
            });
        });

        // Xử lý nút xóa
        $('.delete-btn').click(function() {
            var id = $(this).data('id');
            var url = '{{ route("taikhoan.destroy", ":id") }}'.replace(':id', id);
            $('#deleteForm').attr('action', url);
        });
        // Khởi tạo DataTables
        $('.dataTables-taikhoan').DataTable({
            pageLength: 25,
            responsive: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Tất cả"]
            ],
            order: [], // Không sắp xếp mặc định
            columnDefs: [{
                    orderable: false,
                    targets: [0, 7], // Không sắp xếp cột STT và Thao tác
                    className: 'text-center' // Căn giữa cho cột STT
                },
                {
                    width: "5%",
                    targets: 0
                }, // STT
                {
                    width: "15%",
                    targets: 1
                }, // Họ tên
                {
                    width: "10%",
                    targets: 2
                }, // CCCD
                {
                    width: "15%",
                    targets: 3
                }, // Email
                {
                    width: "10%",
                    targets: 4
                }, // Chức vụ
                {
                    width: "15%",
                    targets: 5
                }, // Loại tài khoản
                {
                    width: "15%",
                    targets: 6
                }, // Đơn vị
                {
                    width: "15%",
                    targets: 7
                } // Thao tác
            ],
            dom: "<'row mb-3'" +
                "<'col-md-4'l>" + // show entries
                "<'col-md-4 text-center'B>" + // buttons
                "<'col-md-4 d-flex justify-content-end'f>" + // search về phải
                ">" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'csv',
                    text: 'CSV',
                    charset: 'utf-8',
                    bom: true //  THÊM DÒNG NÀY để fix lỗi font
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel', // Không dùng title mặc định
                    filename: 'Danh_sach_taikhoan', // Tên file xuất ra
                    exportOptions: {
                        columns: [0, 1, 2] // In ra cột STT, Tên tài khoản, Mô tả
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        var styles = xlsx.xl['styles.xml'];

                        // Đẩy toàn bộ các row xuống 1 hàng (dòng 2 trở đi)
                        $('row', sheet).each(function() {
                            var r = parseInt($(this).attr('r'));
                            $(this).attr('r', r + 1);
                            $(this).find('c').each(function() {
                                var cellRef = $(this).attr('r');
                                var col = cellRef.replace(/[0-9]/g, '');
                                var row = parseInt(cellRef.replace(/[A-Z]/g, '')) + 1;
                                $(this).attr('r', col + row);
                            });
                        });

                        // Thêm dòng tiêu đề chính ở A1
                        var title = `
                            <row r="1">
                                <c t="inlineStr" r="A1" s="50">
                                    <is><t>Danh sách tài khoản</t></is>
                                </c>
                            </row>
                        `;
                        sheet.getElementsByTagName('sheetData')[0].innerHTML = title + sheet.getElementsByTagName('sheetData')[0].innerHTML;

                        // Merge A1 và B1
                        var mergeCells = sheet.getElementsByTagName('mergeCells')[0];
                        if (!mergeCells) {
                            mergeCells = sheet.createElement('mergeCells');
                            sheet.getElementsByTagName('worksheet')[0].appendChild(mergeCells);
                        }

                        var mergeCell = sheet.createElement('mergeCell');
                        mergeCell.setAttribute('ref', 'A1:C1');
                        mergeCells.appendChild(mergeCell);
                        mergeCells.setAttribute('count', mergeCells.getElementsByTagName('mergeCell').length);

                        // Thêm style căn giữa với font-size cho title
                        var cellXfs = styles.getElementsByTagName('cellXfs')[0];
                        var newStyle = `
                                    <xf xfId="0" applyAlignment="1" applyFont="1">
                                        <alignment horizontal="center" vertical="center"/>
                                        <font><sz val="22"/><b/></font>
                                    </xf>
                                `;
                        var headerStyle = `
                                    <xf xfId="0" applyAlignment="1" applyFont="1">
                                        <alignment horizontal="center"/>
                                        <font><sz val="16"/><b/></font>
                                    </xf>
                                `;

                        cellXfs.innerHTML += newStyle + headerStyle;

                        // Gán style: dòng 1 (title) dùng style index 50, dòng 2 (header) dùng style index 51
                        $('row[r="2"] c', sheet).attr('s', '51'); // STT, Tên 
                        $('row[r="1"] c[r="A1"]', sheet).attr('s', '50'); // Danh sách 
                    }

                },
                {
                    extend: 'pdf',
                    title: 'Danh sách tài khoản',
                    exportOptions: {
                        columns: [0, 1, 2] // In ra cột thứ 1, 2 và 3 (đánh số từ 0)
                    },
                    // Tính toán lại STT dựa trên trang hiện tại
                    drawCallback: function(settings) {
                        var api = this.api();
                        var startIndex = api.context[0]._iDisplayStart;

                        api.column(0, {
                            page: 'current'
                        }).nodes().each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                    },
                },
                {
                    extend: 'print',
                    title: 'Danh sách tài khoản',
                    exportOptions: {
                        columns: [0, 1, 2] // In ra cột thứ 1, 2 và 3 (đánh số từ 0)
                    },
                    // Tính toán lại STT dựa trên trang hiện tại
                    drawCallback: function(settings) {
                        var api = this.api();
                        var startIndex = api.context[0]._iDisplayStart;

                        api.column(0, {
                            page: 'current'
                        }).nodes().each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                    },
                    customize: function(win) {
                        $(win.document.body).addClass('white-bg').css('font-size', '10px');
                        $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                    }
                }
            ]
        });
    });
</script>
@endsection