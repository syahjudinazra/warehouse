@extends('layouts.main')
@section('title', __('Work In Progress (WIP)'))
@section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
        </div>
        </div>
    </div>
    <section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-product" onclick="addProduct()"><i class="fas fa-plus"></i> Add New WIP</button>
                <div class="card-tools">
                    <form>
                        <div class="input-group input-group">
                            <input type="text" class="form-control" name="q" placeholder="Search">
                            <input type="hidden" name="category" value="{{ Request::get('category') }}">
                            <input type="hidden" name="sort" value="{{ Request::get('sort') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row col-sm-2">
                    <label for="sort" class="col-sm-4 col-form-label">Sort</label>
                    <div class="col-sm-8">
                        <form id="sorting" action="" method="get">
                            <input type="hidden" name="q" value="{{ Request::get('q') }}">
                            <input type="hidden" name="category" value="{{ Request::get('category') }}">
                            <select class="form-control select2" style="width: 100%;" id="sort" name="sort">
                                <option value="" {{ Request::get('sort') == null? 'selected':'' }}>None</option>
                                <option value="asc" {{ Request::get('sort') == 'asc'? 'selected':'' }}>Ascending</option>
                                <option value="desc" {{ Request::get('sort') == 'desc'? 'selected':'' }}>Descending</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="table" class="table table-sm table-bordered table-hover table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>No.</th>
                                <th>{{ __('Product Code') }}</th>
                                <th>{{ __('Product Name') }}</th>
                                <th>{{ __('Amount') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($products) > 0)
                            @foreach($products as $key => $d)
                            @php
                                $data = [
                                            "no"        => $products->firstItem() + $key,
                                            "pid"       => $d->product_wip_id,
                                            "pcode"     => $d->product_code,
                                            "pname"   => $d->product_name,
                                            "pamount"   => $d->product_amount,
                                        ];
                            @endphp
                            <tr>
                                <td class="text-center">{{ $data['no'] }}</td>
                                <td class="text-center">{{ $data['pcode'] }}</td>
                                <td>{{ $data['pname'] }}</td>
                                <td>{{ $data['pamount'] }}</td>
                                <td class="text-center"><button title="Selesai" type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#wip-complete" onclick="wipComplete({{ json_encode($data) }})"><i class="fas fa-check"></i></button> <button title="Edit" type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#add-product" onclick="editProduct({{ json_encode($data) }})"><i class="fas fa-edit"></i></button> <button title="Hapus" type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete-product" onclick="deleteProduct({{ json_encode($data) }})"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="8">{{ __('No data.') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
        {{ $products->appends(request()->except('page'))->links("pagination::bootstrap-4") }}
        </div>
    </div>
    <div class="modal fade" id="add-product">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Add New WIP') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="save" action="{{ route('products.wip.save') }}" method="post">
                        @csrf
                        <input type="hidden" id="save_id" name="id">
                        <div class="form-group row">
                            <label for="product_code" class="col-sm-4 col-form-label">{{ __('Product Code') }}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="product_code" name="product_code">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product_amount" class="col-sm-4 col-form-label">{{ __('Amount') }}</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="product_amount" name="product_amount" min="1">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button id="button-save" type="button" class="btn btn-primary" onclick="$('#save').submit();">{{ __('Tambahkan') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="delete-product">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Delete Product') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="delete" action="{{ route('products.wip.delete') }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" id="delete_id" name="id">
                    </form>
                    <div>
                        <p>Anda yakin ingin menghapus product code <span id="pcode" class="font-weight-bold"></span>?</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Batal') }}</button>
                    <button id="button-save" type="button" class="btn btn-danger" onclick="$('#delete').submit();">{{ __('Ya, hapus') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="wip-complete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Selesai') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="complete" action="{{ route('products.wip.complete') }}" method="post">
                        @csrf
                        <input type="hidden" id="wip_id" name="wip_id">
                    </form>
                    <div>
                        <p>Anda yakin WIP product code <span id="wip_pcode" class="font-weight-bold"></span> sudah selesai?</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Batal') }}</button>
                    <button id="button-save" type="button" class="btn btn-success" onclick="$('#complete').submit();">{{ __('Ya') }}</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('custom-js')
    <script src="/plugins/toastr/toastr.min.js"></script>
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script>
        $(function () {
            var user_id;
            $('.select2').select2({
            theme: 'bootstrap4'
            });
        });

        $('#sort').on('change', function() {
            $("#sorting").submit();
        });

        function resetForm(){
            $('#save').trigger("reset");
        }

        function addProduct(){
            $('#modal-title').text("Add New WIP");
            $('#button-save').text("Tambahkan");
            resetForm();
        }

        function editProduct(data){
            $('#modal-title').text("Edit");
            $('#button-save').text("Simpan");
            resetForm();
            $('#save_id').val(data.pid);
            $('#product_code').val(data.pcode);
            $('#product_name').val(data.pname);
            $('#product_amount').val(data.pamount);
        }

        function wipComplete(data){
            $('#wip_id').val(data.pid);
            $('#wip_pcode').text(data.pcode);
        }

        function deleteProduct(data){
            $('#delete_id').val(data.pid);
            $('#pcode').text(data.pcode);
        }
    </script>
    @if(Session::has('success'))
        <script>toastr.success('{!! Session::get("success") !!}');</script>
    @endif
    @if(Session::has('error'))
        <script>toastr.error('{!! Session::get("error") !!}');</script>
    @endif
    @if(!empty($errors->all()))
        <script>toastr.error('{!! implode("", $errors->all("<li>:message</li>")) !!}');</script>
    @endif
@endsection