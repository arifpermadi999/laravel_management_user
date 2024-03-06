@extends('layouts')

@section('content')
	<div class="row">
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
          <div class="card-body">
            <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
            <h2 class="mb-5" id="total"></h2>
            <h6 class="card-text">Pengguna Terdaftar</h6>
          </div>
        </div>
      </div>

      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
          <div class="card-body">
            <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image">
            <h2 class="mb-5" id="online"></h2>
            <h6 class="card-text">Pengguna Aktif</h6>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('scripts')
<script type="text/javascript">
        $(function(){
            $.ajax({
                url: "{{ url('api/users/total') }}",
                method: 'GET',
                headers:{'Authorization':'bearer ' + window.localStorage.getItem("token")},
                success: function(response) {
                  $("#total").text(response.data.total);
                  $("#online").text(response.data.online);
                  // do something with the response data
                },
                error: function(jqXHR, textStatus, errorThrown) {
                  console.log(errorThrown);
                  // handle the error case
                }
              });
        })
    </script>
@endsection