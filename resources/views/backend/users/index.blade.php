@extends('layouts.app')

@section('title')
    Users
@endsection

@section('styles')
    <!--Regular Datatables CSS-->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <!--Responsive Extension Datatables CSS-->
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endsection

@section('scripts')
    <!-- jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!--Datatables -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                    responsive: true,
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search user...",
                    },

                    "columnDefs": [{
                        "orderable": false,
                        "targets": 3
                    }]
                })
                .columns.adjust()
                .responsive.recalc();
        });
    </script>
@endsection

@section('content')
    <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="page-heading">All Users</h1>
        <a href="{{ route('admin.users.create') }}" class="service-action-button service-action-button--primary self-start sm:self-auto">Add Receptionist</a>
    </div>

    <div class="bg-gray-100 text-gray-600 tracking-wider leading-normal rounded-lg overflow-y-auto" id="staffModalContainer">
        <div id='recipients' class="page-content-container overflow-x-auto">
            <table id="example" class="stripe hover">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="text-left px-4 py-3">Name</th>
                        <th class="text-left px-4 py-3">Email</th>
                        <th class="text-left px-4 py-3">Role</th>
                        <th class="text-right px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $s)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-4 py-3 font-semibold">{{ $s->name }}</td>
                            <td class="px-4 py-3">{{ $s->email }}</td>
                            <td class="px-4 py-3">{{ $s->roles->first()?->name ?? 'Role assignment required' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex flex-wrap justify-end gap-3">
                                    <a href="{{ route('admin.users.show', $s->id) }}" class="service-action-button service-action-button--secondary">View</a>
                                    <a href="{{ route('admin.users.edit', $s->id) }}"
                                        class="service-action-button service-action-button--secondary">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
