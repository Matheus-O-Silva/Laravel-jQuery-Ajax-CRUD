@extends('layouts.app')

@section('content')

            
<div class="loader-bg">
    <div class="loader-p">
    </div>
</div>
 
<!-- AddStudentModal Modal -->


<div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div id="spinner"></div>

        <div id="success" class="container mb-3" role="alert">
            <div class="container">
                
            </div>
        </div>

        <div id="form-modal" class="modal-body">

           <div class="container">
            <ul id="saveform_errList"></ul>
           </div>

           <div id="alert"><p><strong> Formulário cadastrado com sucesso! </strong></p></div>
          
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

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <h4>Students Data</h4>
                    <a href="" class="btn btn-primary float-end btn-sm" data-bs-toggle="modal" data-bs-target="#AddStudentModal"> Add Student</a>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    
    <script>
        setTimeout(function(){
            $('.loader-bg').fadeToggle();
        },1500);

        $(document).ready(function () {
            
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
                    beforeSend: function(){
                        
                        /* Show image container */

                        $("#spinner").fadeIn('slow');
                        $("#form-modal").hide();    

                    },
                    success: function (response) {
                        //console.log(response.status);

                        if(response.status == 400) {
                            $('#saveform_errList').html("");
                            $('#saveform_errList').addClass('alert alert-danger');
                            $.each(response.errors, function (key, err_values) {
                                $('#saveform_errList').append('<li>'+err_values+'</li>');
                            });
                        }else {
                            $('#saveform_errList').html("");
                            
                            $('#success_message').text(response.message);
                            //$('#AddStudentModal').modal('hide');
                            $('#AddStudentModal').find('input').val("");
                        }
                    },
                    complete:function(response){
                        /* Hide image container */
                            
                        setTimeout(() => {
                        $('#spinner').hide();
                        $('#form-modal').show();
                        $('#alert').addClass('alert alert-success');
                        $('#alert').fadeIn();
                        setTimeout(() => { $('#alert').fadeOut('slow');
                            }, 2000);
                        }, 2000);
                        $('#alert').find('p').val("");

                    }
                });

                //console.log(data)
            });

        });
    </script>

@endsection