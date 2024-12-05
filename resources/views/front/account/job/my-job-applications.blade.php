@extends('front.layouts.app')

@section('main');

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Jobs Applied</h3>
                            </div>
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table" style="width: 100%; border-collapse: collapse; font-family: 'Arial', sans-serif;">
                                <thead style="background: linear-gradient(90deg, #6554C0, #8c7ae6); color: #fff;">
                                    <tr>
                                        <th scope="col" style="padding: 12px; text-align: left; border-bottom: 2px solid #8c7ae6; font-weight: 600;">Title</th>
                                        <th scope="col" style="padding: 12px; text-align: left; border-bottom: 2px solid #8c7ae6; font-weight: 600;">Applied Date</th>
                                        <th scope="col" style="padding: 12px; text-align: left; border-bottom: 2px solid #8c7ae6; font-weight: 600;">Applicants</th>
                                        <th scope="col" style="padding: 12px; text-align: left; border-bottom: 2px solid #8c7ae6; font-weight: 600;">Status</th>
                                        <th scope="col" style="padding: 12px; text-align: left; border-bottom: 2px solid #8c7ae6; font-weight: 600;">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if ($jobApplications->isNotEmpty())
                                        @foreach ($jobApplications as $jobApplication)
                                        <tr style="background-color: #ffffff; border-bottom: 1px solid #ddd; transition: background-color 0.3s; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05); border-radius: 4px;">
                                            <td style="padding: 12px; color: #333; font-size: 14px;">
                                                <div class="job-name fw-500">{{ $jobApplication->job->title }}</div>
                                                {{-- here we will show jobType name using relation --}}
                                                <div class="info1">{{ $jobApplication->job->jobType->name }} . {{ $jobApplication->job->location }}</div>
                                            </td>
                                            <td style="padding: 12px; color: #333; font-size: 14px;">{{ \Carbon\Carbon::parse($jobApplication->applied_date)->format('d M, Y') }}</td>
                                            <td style="padding: 12px; color: #333; font-size: 14px;">{{ $jobApplication->job->applications->count() }} Applications</td>
                                            <td style="padding: 12px; color: #333; font-size: 14px;">
                                                @if ($jobApplication->job->status == 1)
                                                <div class="job-status text-capitalize">active</div>
                                                @else
                                                <div class="job-status text-capitalize">Block</div>
                                                @endif
                                            </td>
                                            <td style="padding: 12px; color: #333; font-size: 14px;">
                                                <div class="action-dots">
                                                    <button href="#" class="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: none; border: none; cursor: pointer; color: #6554C0; font-size: 18px; transition: color 0.3s;">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end" style="background-color: #ffffff; border: 1px solid #ddd; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 8px;">
                                                        <li><a class="dropdown-item" href="{{ route("jobDetail",$jobApplication->job_id) }}" style="color: #333; padding: 8px; font-size: 14px; border-radius: 4px; transition: background-color 0.3s;"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                        <li><a class="dropdown-item" href="#" onclick="removeJob({{ $jobApplication->id }})" style="color: #333; padding: 8px; font-size: 14px; border-radius: 4px; transition: background-color 0.3s;"><i class="fa fa-trash" aria-hidden="true"></i>Remove</a></li>
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
                        <div>
                            {{-- for paginate(10); --}}
                            {{ $jobApplications->links() }}
                        </div>
                    </div>
                </div>

   
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')
{{-- Alert & ajax to delete Jobs --}}
<script type="text/javascript">
function removeJob(id) {
    if (confirm("Are you sure you want to remove?")) {
        $.ajax({
            url: '{{ route("account.removeJobs") }}',
            type: 'post',
            data: {id: id},
            dataType: 'json',
            success: function(response) {
                window.location.href='{{ route("account.myJobApplications") }}';
            }
        });
    }
}
</script>
@endsection