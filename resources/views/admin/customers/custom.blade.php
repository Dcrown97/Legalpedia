@extends('layouts.admin.customers')

@section('title')
    <title>Customers - Legalpedia</title>
@endsection

@section('content')
<style>
    .modal-content {
        width: 100% !important;
        height: auto !important;
    }
    .dataTables_wrapper .dataTables_length {
        padding: 15px 30px;
    }
    .dataTables_wrapper .dataTables_filter {
        padding: 15px 30px;
    }
    .dataTables_wrapper .dataTables_info {
        padding: 15px 30px;
    }
    .dataTables_wrapper .dataTables_paginate {
        padding: 15px 30px;
    }
    .table-bordered {
        border: none !important;
    }
    table.dataTable.no-footer {
        border-bottom: none !important;
    }
    table.dataTable thead th {
        border-bottom: none !important;
    }
    .table-bordered th {
        border: none !important;
    }
    table {
        border: none !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        color: #fff !important;
        border: none !important;
        background: #ec6959 !important;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 10%), 0 4px 6px -2px rgb(0 0 0 / 5%) !important;
        border-radius: 3px !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: #fff !important;
        border: none !important;
        background: #ec6959 !important;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 10%), 0 4px 6px -2px rgb(0 0 0 / 5%) !important;
        border-radius: 3px !important;
    }
</style>
<div class="header">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-end">
                <div class="col">
                    <h6 class="header-pretitle">
                    </h6>
                    <h1 class="header-title">
                        Manage Customers
                    </h1>
                </div>
                @include('elements.notifications')
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card" data-list='{"valueNames": ["orders-order", "orders-product", "orders-date", "orders-total", "orders-status", "orders-method"], "page": 10, "pagination": {"paginationClass": "list-pagination"}}' id="contactsList">
                <div class="card-header">
                    <form class="hidden">
                        <div class="input-group input-group-flush input-group-merge input-group-reverse">
                        <input class="form-control list-search" type="search" placeholder="Search">
                        <span class="input-group-text">
                            <i class="fe fe-search"></i>
                        </span>
                        </div>
                    </form>
                    <div class="col-auto">
                        @php
                            $user_count = App\Models\User::count();
                        @endphp
                        <h4>{{number_format($user_count)}} customers</h4>
                    </div>
                    <div class="col-auto">
                        <form action="{{route('export.customer')}}" method="post">
                            @csrf
                            <button type="submit" id="exportBtn" class="btn btn-primary text-white">
                                <i class="mdi mdi-download"></i> Export
                            </button>
                        </form>
                    </div>
                </div>
                <table id="products-table" class="table table-sm table-nowrap card-table data-table" class="display" style="width:100%">
                    <thead>
                        <th>id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <script>

                    $(function () {

                        var table = $('.data-table').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: "{{ route('user.custom') }}",
                            columns: [
                                {data: 'id', name: 'id'},
                                {data: 'name', name: 'name'},
                                {data: 'email', name: 'email'},
                                {data: 'action', name: 'action', orderable: true, searchable: true},
                            ]
                        });

                    });
                    // $(document).ready(function() {
                    //     $('#products-table').DataTable({
                    //         "serverSide": true,
                    //         "ajax": {
                    //             url: "{{ url('admin/customers/custom') }}",
                    //             method: "get"
                    //         },
                    //         "columnDefs" : [{
                    //             'targets': [4],
                    //             'orderable': false
                    //         }],
                    //     });
                    // });
                </script>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteFunction() {
        if(!confirm("Are you sure you want to delete this user?"))
        event.preventDefault();
    }
    function showEditUserRole(name, id){
        document.getElementById("user-name").value = name;
        // document.getElementById("user-role").value = role;
        document.getElementById("user-id").value = id;
        $('#editUserRole').modal('show')

    }
</script>
@endsection
