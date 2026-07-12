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
    <div class="flex items-center justify-between">
        <h1 class="page-heading">All Users</h1>
        <a href="{{ route('admin.users.create') }}" class="btn-primary">Add User</a>
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
                            <td class="px-4 py-3">{{ $s->roles->first()->name }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex gap-3 justify-end">
                                    <a href="{{ route('admin.users.show', $s->id) }}" class="text-mustBlue hover:text-mustBlue transition duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                          </svg>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $s->id) }}"
                                        class="text-mustBlue hover:text-mustBlue transition duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>


                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
