@extends('layouts.app')

@section('title')
    Patients
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">Patients</h1>
        @can('add patient')
            <a href="{{ route('admin.patients.create') }}" class="btn-primary">Add Patient</a>
        @endcan
    </div>

    <div class="page-content-container overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="text-left px-4 py-3">Patient No.</th>
                    <th class="text-left px-4 py-3">Name</th>
                    <th class="text-left px-4 py-3">Phone</th>
                    <th class="text-left px-4 py-3">Gender</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-right px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($patients as $patient)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 font-semibold">{{ $patient->patient_number }}</td>
                        <td class="px-4 py-3">{{ $patient->full_name }}</td>
                        <td class="px-4 py-3">{{ $patient->phone }}</td>
                        <td class="px-4 py-3">{{ $patient->gender ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $patient->status }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('admin.patients.show', $patient) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                @can('update patient')
                                    <a href="{{ route('admin.patients.edit', $patient) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                                @endcan
                                @can('delete patient')
                                    <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 delete_item">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">No patients registered yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
