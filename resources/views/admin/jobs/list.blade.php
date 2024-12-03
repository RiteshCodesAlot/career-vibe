@extends('front.layouts.app')

@section('main');

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Jobs</li>
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
                                <h3 class="fs-4 mb-1">Jobs</h3>
                            </div>
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if ($jobs->isNotEmpty())
                                        @foreach ($jobs as $job)
                                        <tr class="active">
                                            <td>{{ $job->id }}</td>
                                            <td>
                                                {{-- <div class="job-name fw-500">{{ $job->title }}</div> --}}
                                                <p>{{ $job->title }}</p>
                                                <p>Applicants: {{ $job->Applications->count() }}</p>
                                            </td>
                                            <td>{{ $job->user->name }}</td>
                                            <td>
                                                @if ($job->status == 1)
                                                    <p style="background-color: #2c753d; color: #ffffff; padding: 2px; border-radius: 15px; text-align: center; font-size: 13px; margin: 0;">Active</p>
                                                @else
                                                    <p style="background-color: #c51c2d; color: #ffffff; padding: 2px; border-radius: 15px; text-align: center; font-size: 13px; margin: 0;">Block</p>
                                                @endif
                                            </td>                                            
                                            <td>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</td>
                                            <td>
                                                <div class="action-dots ">
                                                    <button href="#" class="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href={{ route('admin.jobs.edit', $job->id) }}"> <i class="fa fa-eye" aria-hidden="true"></i>Edit</a></li>
                                                        <li><a class="dropdown-item" onclick="deleteJob({{ $job->id }})" href="#"><i class="fa fa-trash" aria-hidden="true"></i>Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5">Job Applications Not Found</td>
                                    </tr>
                                    @endif

                                </tbody>
                                
                            </table>
                        </div>
                        <div>
                            {{-- for paginate(10); --}}
                            {{ $jobs->links() }}
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
    function deleteJob(id) {
        if(confirm("Are you sure you want to delete..?")) {
            $.ajax({
                url: '{{ route("admin.jobs.destroy") }}',
                type: 'delete',
                data: { id: id},
                dataType: 'json',
                success: function(response) {
                    window.location.href = "{{ route('admin.jobs') }}";
                }
            });
        }
    }
</script>

@endsection



