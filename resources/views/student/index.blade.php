@extends('layouts.app')

@section('content')

<!-- AddStudentModal Modal -->
<div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div id="save_msgList"></div>

          <div class="form-group mb-3">
              <label for="Student Name"> Name</label>
              <input type="text" class="name form-control">
          </div>
          <div class="form-group mb-3">
              <label for="Student Name">Email</label>
              <input type="text" class="email form-control">
          </div>
          <div class="form-group mb-3">
              <label for="Student Name">Phone</label>
              <input type="text" class="phone form-control">
          </div>
          <div class="form-group mb-3">
              <label for="Student Name">Course</label>
              <input type="text" class="course form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add_student">Save</button>
        </div>
      </div>
    </div>
</div>

<!-- End AddStudentModal Modal -->

<!-- Edit Student Modal -->
<div class="modal fade" id="EditStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div id="update_msgList"></div>

            <input type="hidden" id="stud_id" />

          <div class="form-group mb-3">
              <label for="Student Name"> Name</label>
              <input type="text" id="edit_name" class="name form-control">
          </div>
          <div class="form-group mb-3">
              <label for="Student Name">Email</label>
              <input type="text" id="edit_email" class="email form-control">
          </div>
          <div class="form-group mb-3">
              <label for="Student Name">Phone</label>
              <input type="text" id="edit_phone" class="phone form-control">
          </div>
          <div class="form-group mb-3">
              <label for="Student Name">Course</label>
              <input type="text" id="edit_course" class="course form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary update_student">Update</button>
        </div>
      </div>
    </div>
</div>
<!-- End Edit Student Modal -->

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div id="success_message"></div>

            <div class="card">
                <div class="card-header">
                    <h4>Students Data</h4>
                    <a href="" class="btn btn-primary float-end btn-sm" data-bs-toggle="modal" data-bs-target="#AddStudentModal"> Add Student</a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Course</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Aqui a tabela é carregada via Jquery --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    
    <script>

        $(document).ready(function () {

            fetchStudent();

            function fetchStudent() {
                $.ajax({
                    type: "GET",
                    url: "/fetch-students",
                    dataType: "Json",
                    success: function (response) {
                        $.each(response.students , function (key, item) { 
                             $('tbody').append('<tr>\
                                    <td>' +item.id +'</td>\
                                    <td>' + item.name + '</td>\
                                    <td>' + item.email + '</td>\
                                    <td>' + item.phone + '</td>\
                                    <td>' + item.course + '</td>\
                                    <td>as</td>\
                                    <td><button type="button" value="' + item.id + '" class="btn btn-primary edit_student btn-sm">Edit</button></td>\
                                    <td><button type="button" value="' + item.id + '" class="btn btn-danger  deletebtn btn-sm">Delete</button></td>\
                                </tr>');
                        });
                    }
                });
            } 

            $(document).on('click', '.deletebtn', function (e) {
                e.preventDefault();

                var id = $('.deletebtn').val();

                console.log(id);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                
                $.ajax({
                    type: "DELETE",
                    url: "/delete-student/" + id,
                    dataType: "json",
                    success: function (response) {
                        swal({
                            title: "Você está certo disso?",
                            text: "Uma vez deletado, você não terá como recuperar a informação!",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                swal("Feito! Cadastro deletado com sucesso! ", {
                                icon: "success",
                                });
                                if (response.status == 404) {
                                    $('#success_message').text(response.message);
                                } else {
                                    $('tbody').html("");
                                    fetchStudent();
                                }
                            } else {
                                swal("Seu Cadastro está a salvo!");
                            }
                        });

                    }
                });

            });


            $(document).on('click', '.update_student', function (e) {
                e.preventDefault();
                var stud_id = $('#stud_id').val()

                var data = {
                    'name' : $('#edit_name').val(),
                    'email' : $('#edit_email').val(),
                    'phone' : $('#edit_phone').val(),
                    'course' : $('#edit_course').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: "update-students/"+stud_id,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        $('tbody').html("");
                        if (response.status == 400) {
                            $('#update_msgList').html("");
                            $('#update_msgList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_value) {
                                $('#update_msgList').append('<li>' + err_value + '</li>');
                            });
                        } else {

                            swal({
                            title: "Feito",
                            text: "Registro atualizado com sucesso!",
                            icon: "success",
                            button: "fechar",
                            });

                            $('#update_msgList').html("");
                            $('#EditStudentModal').find('input').val('');
                            $('.update_student').text('Update');
                            $('#EditStudentModal').modal('hide');
                            fetchStudent();
                        }                       


                    }
                });
            });

            $(document).on('click','.edit_student', function (e) {
                e.preventDefault();
                var stud_id = $(this).val();
                $('#EditStudentModal').modal('show');

                $.ajax({
                    type: "GET",
                    url: "/edit-students/"+stud_id,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 404) {
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {
                            $('#edit_name').val(response.student.name);
                            $('#edit_course').val(response.student.course);
                            $('#edit_email').val(response.student.email);
                            $('#edit_phone').val(response.student.phone);
                            $('#stud_id').val(stud_id);
                        }
                    }
                });

                $('.btn-close').find('input').val('');

            });
            
            $(document).on('click', '.add_student', function (e) {
                e.preventDefault();
                var data = {
                    'name'   : $('.name').val(),
                    'email'  : $('.email').val(),
                    'phone'  : $('.phone').val(),
                    'course' : $('.course').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/create-student",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        $('tbody').html("");
                        if (response.status == 400) {
                        $('#save_msgList').html("");
                        $('#save_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#save_msgList').append('<li>' + err_value + '</li>');
                        });
                        $('.add_student').text('Save');
                        } else {
                            swal({
                            title: "Feito",
                            text: "Cadastro realizado com sucesso!",
                            icon: "success",
                            button: "fechar",
                            });
                            $('#save_msgList').html("");
                            $('#AddStudentModal').find('input').val('');
                            $('.add_student').text('Save');
                            $('#AddStudentModal').modal('hide');
                            fetchStudent();
                        }
                }
                });

                //console.log(data)
            });

        });
    </script>

@endsection