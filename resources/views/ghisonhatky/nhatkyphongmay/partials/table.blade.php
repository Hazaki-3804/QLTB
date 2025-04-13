<div class="ibox-content">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dataTables-nkphongmay" style="font-size: 12px;">
            <thead>
                <tr>
                    <th style="text-align: center;">STT</th>
                    <th style="text-align: center;">Ngày</th>
                    <th>Giờ vào</th>
                    <th>Giờ ra</th>
                    <th>Mục đích sử dụng</th>
                    <th>Tình trạng trước khi sử dụng</th>
                    <th>Tình trạng sau khi sử dụng</th>
                    <th>Giáo viên sử dụng</th>
                    <th style="text-align: center;">Thao tác</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@include('ghisonhatky.nhatkyphongmay.partials.modals')
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script>
    $(document).ready(function() {
        console.log("ready");
        // Khởi tạo autocomplete cho trường tìm kiếm phòng máy
        $("#phongSearch").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('nhatkyphongmay.search-phong') }}",
                    method: "GET",
                    async: false,
                    data: {
                        q: request.term
                    },
                    success: function(data) {
                        console.log(data);
                        response(data.map(function(item) {
                            return {
                                label: item.maphong + " (" + item.tenphong + ")",
                                id: item.id,
                                somay: item.somay,
                                tenphong: item.tenphong,
                                tengvql: item.tengvql,
                            };
                        }));
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching data:", error);
                        console.error("Response:", xhr.responseText);
                    }
                });
            },
            appendTo: ".form-group.autocomplete",
            select: function(event, ui) {
                $("#phongSearch").val(ui.item.label);
                sessionStorage.setItem("id", ui.item.id);
                sessionStorage.setItem("tenphong", ui.item.tenphong);
                // console.log("ID:", ui.item.id);
                // console.log("Tên phòng:", ui.item.tenphong);
                // console.log("Số máy:", ui.item.somay);
                // console.log("GVQL:", ui.item.tengvql);

                if (ui.item.somay) {
                    $("#khongcosodo").addClass("hidden");
                    $("#sodophongmay").removeClass("hidden");
                    sodophongmay(ui.item.somay);
                } else {
                    $("#khongcosodo").removeClass("hidden");
                    $("#sodophongmay").addClass("hidden");
                }
                $("#gvql").text(ui.item.tengvql);

                if (table) {
                    table.ajax.reload();
                }
                return false;
            },
            change: function(event, ui) {
                if (!ui.item) {
                    $("#phongSearch").val("");
                    sessionStorage.removeItem("id");
                    sessionStorage.removeItem("tenphong");
                    $("#khongcosodo").removeClass("hidden");
                    $("#sodophongmay").addClass("hidden");
                }
            },
        });
        const updateAutocompleteWidth = () => {
            const $input = $("#phongSearch");
            const $menu = $input.autocomplete("widget");
            const inputWidth = $input.outerWidth();
            $menu.css("width", inputWidth + "px");
        };

        // Gọi lúc mở autocomplete
        $("#phongSearch").on("autocompleteopen", updateAutocompleteWidth);

        // Gọi khi resize window (responsive)
        $(window).on("resize", updateAutocompleteWidth);
        // Khởi tạo DataTable
        let table = $('.dataTables-nkphongmay').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('nhatkyphongmay.loadTable') }}",
                type: 'GET',
                data: function(d) {
                    d.idphong = sessionStorage.getItem("id") || $('#phongSearch').val() || '';
                    d.idhocky = $('#hockySearch').val() || '';
                    console.log("idphong:", d.idphong, "idhocky:", d.idhocky);
                },
                dataSrc: 'data',
                dataFilter: function(data) {
                    let json = JSON.parse(data);
                    if (!json.data || !Array.isArray(json.data)) {
                        console.warn("Dữ liệu không hợp lệ, trả về mảng rỗng.");
                        json.data = [];
                    }
                    return JSON.stringify(json);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });
                    alert("Không thể tải dữ liệu. Vui lòng thử lại.");
                }
            },
            initComplete: function(settings, json) {
                console.log("Data loaded:", json);
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'ngay',
                    render: function(data, type, row) {
                        return data && moment(data).isValid() ? moment(data).format('DD/MM/YYYY') : 'Không có';
                    }
                },
                {
                    data: 'giovao',
                    render: function(data) {
                        return data || 'Không có';
                    }
                },
                {
                    data: 'giora',
                    render: function(data) {
                        return data || 'Không có';
                    }
                },
                {
                    data: 'mucdichsd',
                    render: function(data) {
                        return data || 'Không có';
                    }
                },
                {
                    data: 'tinhtrangtruoc',
                    render: function(data) {
                        return data || 'Không có';
                    }
                },
                {
                    data: 'tinhtrangsau',
                    render: function(data) {
                        return data || 'Không có';
                    }
                },
                {
                    data: 'taikhoan.hoten',
                    render: function(data, type, row) {
                        return row.taikhoan && row.taikhoan.hoten ? row.taikhoan.hoten : 'Không có';
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                        <a href="#" class="btn btn-warning btn-sm edit-btn"
                            data-tooltip="Cập nhật"
                            data-id="${row.id}"
                            data-toggle="modal"
                            data-target="#editPMModal">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm delete-btn"
                            data-tooltip="Xóa"
                            data-id="${row.id}"
                            data-toggle="modal"
                            data-target="#deletePMModal">
                            <i class="fa fa-trash"></i>
                        </a>
                    `;
                    }
                }
            ],
            buttons: [{
                    extend: 'copyHtml5'
                },
                {
                    extend: 'excelHtml5'
                },
                {
                    extend: 'csvHtml5'
                },
                {
                    extend: 'pdfHtml5'
                }
            ],
        });

        // Tạo sơ đồ phòng máy
        function sodophongmay(somay) {
            var sodophongmay = document.getElementById("sodophongmay");
            sodophongmay.innerHTML = "";
            for (let i = 1; i <= somay; i++) {
                var button = document.createElement("button");
                button.className = "status_phongmay";
                button.setAttribute("data-tooltip", "Máy " + i);
                button.setAttribute("data-toggle", "modal");
                button.setAttribute("data-target", "#modalUpdateStatus");
                button.innerHTML = `${i.toString().padStart(2, '0')}`;
                sodophongmay.appendChild(button);
            }
        }

        // Test URL
        console.log("URL:", "{{ route('nhatkyphongmay.loadTable') }}");

        // Xử lý sự kiện thay đổi học kỳ
        $('#hockySearch').on('change', function() {
            console.log("Học kỳ thay đổi:", $(this).val());
            if (table) {
                table.ajax.reload();
            } else {
                console.error("DataTable chưa được khởi tạo!");
            }
        });

        // Xử lý sự kiện thay đổi mã phòng
        $('#phongSearch').on('change', function() {
            console.log("Mã phòng thay đổi:", $(this).val());
            if (table) {
                table.ajax.reload();
            } else {
                console.error("DataTable chưa được khởi tạo!");
            }
        });
    });
    $(document).on('click', '.edit-btn', function() {
        console.log("Edit button clicked");
        // Lấy ID từ thuộc tính data-id của nút bấm
        var id = $(this).data('id');
        console.log("Edit button clicked for ID:", id);
        $('#edit-phong').val(sessionStorage.getItem("tenphong"));
    });
</script>
@endsection