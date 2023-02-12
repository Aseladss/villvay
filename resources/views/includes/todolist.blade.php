@if(sizeof($todos) > 0)
<div class="box box-primary">
    <div class="box-header with-border" style="background-color: #fff;">
        <b>MANAGE Todos</b>
    </div>
    <div class="box-body no-padding">
        <table class="table table-condensed table-responsive table-striped" id="all-inv-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>DESCRIPTION</th>
                    <th>CREATED ON</th>
                    <th>STATUS</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($todos as $todo)
                @if($todo->status == '0')
                <tr style="background-color: #f8f8f8;">
                    @endif

                    <td>{{ $todo->id }}</td>
                    <td>{{ $todo->name }}</td>
                    <td>{{ $todo->description }}</td>
                    <td>{{ $todo->created_at }}</td> 
                    @if($todo->status == '0')
                    <td>
                        <span class="label label-primary">pending</span>
                    </td>
                    <td><button class="btn btn-block btn-sm bg-blue-active" id="complete-btn" data-id="{{ $todo->id }}">Complete</button></td>

                    @elseif($todo->status == '1')
                    <td>
                        <span class="label label-info">completed</span>
                    </td>
                    <td></td>
                    @endif
                    <td><button class="btn btn-block btn-danger btn-sm" id="delete-btn" data-id="{{ $todo->id }}">Delete</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="row">
    <div class="col-md-12">
        <div class="alert" role="alert" style="background-color: rgb(243, 156, 18, 0.7); font-weight: 800;">No data to show</div>
    </div>
</div>
@endif

