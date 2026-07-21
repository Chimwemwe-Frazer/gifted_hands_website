@extends('layouts.app')

@section('title')
    Users
@endsection

@section('styles')
    <!--Regular Datatables CSS-->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endsection

@section('scripts')
    <!-- jQuery -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <!--Datatables -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search user...",
                },

                "columnDefs": [{
                    "orderable": false,
                    "targets": 3
                }]
            });

            $(window).on('resize', function() {
                table.columns.adjust();
            });
        });
    </script>
@endsection

@section('content')
    <div class="mb-5 flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:justify-between md:mb-0">
        <h1 class="page-heading">All Users</h1>
        <a href="{{ route('admin.users.create') }}" class="service-action-button service-action-button--primary self-start sm:self-auto">Add Receptionist</a>
    </div>

    <div id="staffModalContainer">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:hidden">
            @forelse ($users as $s)
                <article data-mobile-user-card class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="border-b border-gray-100 pb-4">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Staff member</p>
                        <h2 class="mt-1 break-words text-lg font-bold text-mustBlue">{{ $s->name }}</h2>
                        <a href="mailto:{{ $s->email }}" class="mt-1 block break-all text-sm leading-6 text-mustBlue hover:text-mustGreen">
                            {{ $s->email }}
                        </a>
                    </div>

                    <dl class="py-4 text-sm">
                        <dt class="font-semibold text-gray-500">Role</dt>
                        <dd class="mt-1 break-words text-gray-800">{{ $s->roles->first()?->name ?? 'Role assignment required' }}</dd>
                    </dl>

                    <div class="grid grid-cols-2 gap-3 border-t border-gray-100 pt-4">
                        <a href="{{ route('admin.users.show', $s->id) }}" class="service-action-button service-action-button--secondary w-full">View</a>
                        <a href="{{ route('admin.users.edit', $s->id) }}" class="service-action-button service-action-button--secondary w-full">Edit</a>
                    </div>
                </article>
            @empty
                <div class="page-content-container text-center text-gray-500 md:col-span-2">
                    No staff users have been created yet.
                </div>
            @endforelse
        </div>

        <div id="recipients" class="page-content-container hidden xl:block">
            <table id="example" class="stripe hover w-full table-fixed">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="text-left px-4 py-3">Name</th>
                        <th class="text-left px-4 py-3">Email</th>
                        <th class="text-left px-4 py-3">Role</th>
                        <th class="text-right px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $s)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="break-words px-4 py-3 font-semibold">{{ $s->name }}</td>
                            <td class="break-all px-4 py-3">{{ $s->email }}</td>
                            <td class="break-words px-4 py-3">{{ $s->roles->first()?->name ?? 'Role assignment required' }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex flex-wrap justify-end gap-3">
                                    <a href="{{ route('admin.users.show', $s->id) }}" class="service-action-button service-action-button--secondary">View</a>
                                    <a href="{{ route('admin.users.edit', $s->id) }}"
                                        class="service-action-button service-action-button--secondary">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-gray-500">No staff users have been created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
