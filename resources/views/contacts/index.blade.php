@extends('auth.layouts')

@section('content')

<div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Contacts List</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-primary" href="{{ route('contacts.create') }}"> Create Contact</a>
                </div>
                <div class="col-md-2 pull-left mb-2">
                    <select class="form-control" id="dropdown-list">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
                <div class="col-md-2 pull-left mb-2">
                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Search by name">
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Company Address</th>
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody id="contact-list">
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->id }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>{{ $contact->address }}</td>
                        <td>
                            <form action="{{ route('contacts.destroy',$contact->id) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('contacts.edit',$contact->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit"  onclick="return confirm('Are you sure to delete this contact?')" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        {!! $contacts->links() !!}
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    $( document ).ready(function() {
        $("#dropdown-list").on('change', function(){
            var orderBy = document.getElementById("dropdown-list").value;
            $("#contact-list").html('');
            if(orderBy == 'asc')
            {
                var orderBy = 1;
            } else if(orderBy == 'desc')
            {
                var orderBy = 2;
            }

            $.ajax({
                    url: "{{url('/contacts/orderby-contacts')}}",
                    type: "POST",
                    data: {
                        order_by: orderBy,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',                 
                    success: function (result) {                        
                        $("#contact-list").html(result);
                    }
                    });
        });

        $("#keyword").on('keyup', function(){
            var keyword = document.getElementById("keyword").value;
            $.ajax({
                    url: "{{url('/contacts/search-contacts')}}",
                    type: "POST",
                    data: {
                        keyword: keyword,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',                 
                    success: function (result) {                        
                        $("#contact-list").html(result);
                    }
                    });
        });
    });    
    </script>
@endsection
