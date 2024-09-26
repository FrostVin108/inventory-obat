@extends('layouts.app')

@section('content_header')
    <h1>Registered User</h1> 
@stop

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<div class="card">
    <div class="card-body">
        <h2>All Registered users</h2>
        <br>
        <a href="{{ route('user.add')}}"><h4>Add More Users</h4></a>

        <table class="table table-hover" id="users">
            <thead>
                <tr>
                    <th scope="col" >No</th>
                    <th scope="col" >Name</th>
                    <th scope="col" >Email</th>
                    <th scope="col" >Role</th>
                    <th scope="col" >Created At</th>
                    <th scope="col" >Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        
    </div>
</div>

<style>

    .dataTables_length select {
        width: 70px !important;
        height: 30px !important;
        padding: 5px !important;
        border: 1px solid #ccc !important;
        border-radius: 4px !important;
    }
    
</style>


@stop

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
 $(document).ready(function() {
    $('#users').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('users.data') }}',
            columns: [
                { data: null, searchable: false, orderable: false, 
              render: function (data, type, row, meta) {
                return meta.row + 1;
              }
            },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'role', name: 'role' },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        return moment(data).format('YYYY-MM-DD HH:mm:ss');
                    }
                },
                { data: 'action', name: 'action', searchable: false, orderable: false }
            ]
    });
});
</script>

<style>
    .btn {
    margin-right: 5px;
    float: left;
}
</style>
@endpush