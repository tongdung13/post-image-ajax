<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>

    <hr>
    <div class="container">
        <div style="text-align:right">
            <a href="" class="btn btn-sm btn-primary" id="Add">Add</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>User</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody id="blogs">
                @foreach ($blogs as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>
                            @if (!empty($item->user_id) && isset($item->user->name))
                                {{ $item->user->name }}
                            @endif
                        </td>
                        <td>
                            <img src="{{ $item->image }}" style="height: 100px" alt="">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $blogs->links('pagination::bootstrap-5') }}
    </div>


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="myForm" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" name="image" class="form-control" id="image">
                        </div>
                        <div class="form-group">
                            <label for="">User</label>
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="">User</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-save">Submit</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function() {
            $('#Add').click(function(e) {
                e.preventDefault();
                $('#staticBackdrop').modal('show')
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#btn-save').click(function(e) {
                e.preventDefault();
                var url = '{{ route('blogs.store') }}';
                var form = new FormData();
                var name = $('#name').val();
                var image = $('#image')[0].files[0];
                form.append('name', name);
                form.append('image', image);
                $.ajax({
                    type: "post",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: form,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(response) {

                        var blog = '<tr><td>' + response.name +
                            '</td><td><img src=' + response.image +
                            ' style="height:100px" alt="" /> </td></tr>';
                        // hien o duoi
                        // $('#blogs').append(blog);
                        // hien o tren
                        $('#blogs').prepend(blog);
                        $('#myForm').trigger("reset");
                        $('#staticBackdrop').modal('hide')
                    }
                });
            });
        });
    </script>


</body>

</html>
