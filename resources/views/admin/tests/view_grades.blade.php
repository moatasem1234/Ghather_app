@extends('admin.layouts.app')

@section('title')
    Test Grades {{ $test->title }}
@endsection
<?php $menu = 'Grades';
$submenu = ''; ?>

@section('content')
    <div class="card">
        <div class="card-header">
            Grades for Test: {{ $test->title }}
        </div>
        <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"  rel="stylesheet" type="text/css">
        <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"  rel="stylesheet" type="text/css">
        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Score</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($grades as $grade)
                        <tr>
                            <td>{{ $grade->user->name }}</td>
                            <td>{{ $grade->score }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <form action="{{ route('tests.send_grades', $test->id) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary mt-3">Send Grades to Students</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable( {
                searching: true,
                info : true,
                paging: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf','print'
                ]
            } );
        } );
    </script>
@endsection
