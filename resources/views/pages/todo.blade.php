@extends('layouts.adminlayout')
@section('title', 'Todo-list Management')
@section('header', 'Todo-list Management')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<div class="row">
    <div class="col-md-4" style="margin-bottom: 10px;">
        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">New Todo</button>
    </div>
    <div class="col-md-12" id="todo">
        @include('includes.todolist')
    </div>
</div>

<!-- Modal -->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create a Todo</h4>
            </div>
            <div class="modal-body">
                <form id="ticket-form" action="{{ URL('/todo') }}" method="POST">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" >
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    
        $(document).on("click", "#delete-btn", function (e) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).data('id');
                $.ajax({
                    type: 'DELETE',
                    url: "{{ URL:: to('todo') }}/" + id,
                    data: { _token: '{{csrf_token()}}'},
                    success: function (data)
                    {
                        $('#todo').html('');
                        $('#todo').html(data);
                        $("#success-message").html("Your action was successful!");
                        Swal.fire(
                                'Deleted!',
                                'You have deleted.',
                                'success'
                                );

                    }, error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    });
    
    
        $(document).on("click", "#complete-btn", function (e) {
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, complete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).data('id');
                $.ajax({
                    type: 'PUT',
                    url: "{{ URL:: to('todo') }}/" + id,
                    data: { _token: '{{csrf_token()}}'},
                    success: function (data)
                    {
                        $('#todo').html('');
                        $('#todo').html(data);
                        $("#success-message").html("Your action was successful!");
                        Swal.fire(
                                'Success!',
                                'You have completed the todo.',
                                'success'
                                );

                    }, error: function (error) {
                        console.log(error);
                    }
                });
            }
        });
    });
    
    
    
    
    
</script>        
@endsection
