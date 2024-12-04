@extends('front.layouts.app')

@section('main');

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('admin.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')
                <div class="card border-0 shadow mb-4">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Users</h3>
                            </div>
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width: 100%; border-collapse: collapse; font-family: 'Arial', sans-serif;">
                              <thead style="background: linear-gradient(90deg, #6554C0, #8c7ae6); color: #fff;">
                                <tr>
                                  <th scope="col" style="padding: 12px; text-align: left; border-bottom: 2px solid #8c7ae6; font-weight: 600;">ID</th>
                                  <th scope="col" style="padding: 12px; text-align: left; border-bottom: 2px solid #8c7ae6; font-weight: 600;">Name</th>
                                  <th scope="col" style="padding: 12px; text-align: left; border-bottom: 2px solid #8c7ae6; font-weight: 600;">Email</th>
                                  <th scope="col" style="padding: 12px; text-align: left; border-bottom: 2px solid #8c7ae6; font-weight: 600;">Mobile</th>
                                  <th scope="col" style="padding: 12px; text-align: left; border-bottom: 2px solid #8c7ae6; font-weight: 600;">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if ($users->isNotEmpty())
                                  @foreach ($users as $user)
                                    <tr style="background-color: #ffffff; border-bottom: 1px solid #ddd; transition: background-color 0.3s; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05); border-radius: 4px;">
                                      <td style="padding: 12px; color: #333; font-size: 14px;">{{ $user->id }}</td>
                                      <td style="padding: 12px; color: #333; font-size: 14px; font-weight: 500;">{{ $user->name }}</td>
                                      <td style="padding: 12px; color: #333; font-size: 14px;">{{ $user->email }}</td>
                                      <td style="padding: 12px; color: #333; font-size: 14px;">{{ $user->mobile }}</td>
                                      <td style="padding: 12px; text-align: center;">
                                        <div class="action-dots">
                                          <button href="#" class="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: none; border: none; cursor: pointer; color: #6554C0; font-size: 18px; transition: color 0.3s;">
                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </button>
                                          <ul class="dropdown-menu dropdown-menu-end" style="background-color: #ffffff; border: 1px solid #ddd; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 8px;">
                                            <li><a class="dropdown-item" href="{{ route("admin.users.edit", $user->id) }}" style="color: #333; padding: 8px; font-size: 14px; border-radius: 4px; transition: background-color 0.3s;"> <i class="fa fa-eye" aria-hidden="true"></i> Edit</a></li>
                                            <li><a class="dropdown-item" href="#" onclick="deleteUser({{ $user->id }})" style="color: #333; padding: 8px; font-size: 14px; border-radius: 4px; transition: background-color 0.3s;"> <i class="fa fa-trash" aria-hidden="true"></i> Delete</a></li>
                                          </ul>
                                        </div>
                                      </td>
                                    </tr>
                                  @endforeach
                                @else
                                  <tr>
                                    <td colspan="5" style="text-align: center; padding: 15px; color: #6554C0; font-size: 16px; font-weight: 500;">Job Applications Not Found</td>
                                  </tr>
                                @endif
                              </tbody>
                            </table>
                          </div>
                            {{-- for paginate(10); --}}
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
   
            </div>
        </div>
    </div>
</section>

@endsection


@section('customJs')

<script type="text/javascript">
    function deleteUser(id) {
        if(confirm("Are you sure you want to delete..?")) {
            $.ajax({
                url: '{{ route("admin.users.destory") }}',
                type: 'delete',
                data: { id: id},
                dataType: 'json',
                success: function(response) {
                    window.location.href = "{{ route('admin.users') }}";
                }
            });
        }
    }
</script>

@endsection




