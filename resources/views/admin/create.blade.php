@extends('admin.layouts')
<style>
    * {font-family: 'Segoe UI';}
th {text-align: left; font-weight: 600;}
table {border-collapse: collapse; border: 1px solid #999; width: 100%;}
table td,
table th {border: 1px solid #ccc;}
table input {max-width: 100%; border: 1px solid #ccc;}
/* table td:first-child input {width: 60px;} */
#master {display: none;}
</style>
@section('content')
<style>
    .error{
        color:red;
    }
</style>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>Add Order</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route('admin.orders') }}"> Back</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        <form id="orderForm" action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($errors->any())
            <div class="notification is-danger is-light">
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <div class="form-group">
                        <strong>User Name *</strong>
                        <select name="username" class="form-control">
                            <option value="">Select User Name</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('username')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <br>
            <table>
                <thead>
                    <tr>
                    <th>Product *</th>
                    <th>Quantity *</th>
                    <th>Amount *</th>
                    <th>Total *</th>
                    </tr>
                </thead>
                <tbody>
                     <tr>
                    <td><input type="text" name="name[]" class="Product" /></td>
                    <td><input type="text" name="qty[]" class="Quantity" oninput="this.value=this.value.replace(/[^0-9]/g,'');"/></td>
                    <td><input type="text" name="amount[]" class="Rate" oninput="this.value=this.value.replace(/[^0-9]/g,'');"></td>
                    <td><input type="text" name="total[]" class="Amount" readonly=""/></td>
                    </tr>
                    <tr id="master">
                    <td><input type="text" name="name[]" class="Product"/></td>
                    <td><input type="text" name="qty[]" class="Quantity" oninput="this.value=this.value.replace(/[^0-9]/g,'');"/></td>
                    <td><input type="text" name="amount[]" class="Rate" oninput="this.value=this.value.replace(/[^0-9]/g,'');"/></td>
                    <td><input type="text" name="total[]" class="Amount" readonly=""/></td>
                    <td><input type="button" value="&times;" class="del" /></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                    <th colspan="3">Grand Total</th>
                    <th><input type="hidden" name="grand_total" id="grand_total"/><span id="total_amt">0</span> ₹</th>
                    </tr>
                </tfoot>
            </table>
            <br>
            <input type="button" value="Add New" id="add" />
            <div class="form-group" style="padding-top:10px;">
                <button type="submit" class="btn btn-primary ml-3">Submit</button>
            </div>
        </form>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
<script>
$(function () {
    $("#add").click(function () {
        $("#master").clone().removeAttr("id").appendTo("tbody");
    });
    
    $("#orderForm").validate({
        ignore: [],
        rules: {
            username: {
                required: true,
            },
            'name[]': {
                required: true,
            },
            'qty[]': {
                required: true,
            },
            'amount[]': {
                required: true,
            }
        },
        messages: {
            username: {
                required: "Please select user name.",
            },
            'name[]': {
                required: "Please enter product name.",
            },
            'qty[]': {
                required: "Please enter quantity.",
            },
            'amount[]': {
                required: "Please enter an amount.",
            }
        },
        submitHandler: function(form) {
          form.submit();
        }
    });
    $("table").on("click", ".del", function () {
        $(this).closest("tr").remove();
    });
    $("table").on("input", "input", function () {
        $("tbody tr").each(function () {
        $this = $(this);
        if (this.id != "master")
            $this.find(".Amount").val(+$this.find(".Quantity").val() * +$(this).find(".Rate").val());
        $("#total_amt, #total_qty").text(0);
        $(".Amount").each(function () {
            if (this.value != "")
                var total = parseInt($("#total_amt").text()) + parseInt($(this).val());
                $("#total_amt").text(total);
                var grand_total = $('#total_amt').text();
                $("#grand_total").val(grand_total);
        });
        $(".Quantity").each(function () {
            if (this.value != "")
            $("#total_qty").text(parseInt($("#total_qty").text()) + parseInt($(this).val()));
        });
        });
    });
});
</script>
@endsection
