
        <!-- Topbar End -->
  


        <!-- Search Modal -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-transparent">
                    <div class="card mb-0 shadow-none">
                        <div class="px-3 py-2 d-flex flex-row align-items-center" id="top-search">
                            <i class="ti ti-search fs-22"></i>
                            <input type="search" class="form-control border-0" id="search-modal-input" placeholder="Search for actions, people,">
                            <button type="button" class="btn p-0" data-bs-dismiss="modal" aria-label="Close">[esc]</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <div class="page-content">

            <div class="page-container">


                <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column gap-2">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 text-uppercase fw-bold mb-0">Hover</h4>
                    </div>

                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">KSG</a></li>

                            <li class="breadcrumb-item"><a href="javascript: void(0);">DENIS</a></li>

                            <li class="breadcrumb-item active">AGENT</li>
                        </ol>
                    </div>
                </div>




                <div class="row">
                    <div class="col">
                        <div class="row row-cols-xxl-4 row-cols-md-2 row-cols-1 text-center">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted fs-13 text-uppercase" title="Number of Orders">{{ \Carbon\Carbon::now()->format('F Y') }}</h5>
                                        <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1">
                                            <div class="user-img fs-42 flex-shrink-0">
                                                <span class="avatar-title text-bg-primary rounded-circle fs-22">
                                                    <iconify-icon icon="solar:case-round-minimalistic-bold-duotone"></iconify-icon>
                                                </span>
                                            </div>
                                            <h3 class="mb-0 fw-bold">number</h3>
                                        </div>
                                        <p class="mb-0 text-muted">
                                            <span class="text-danger me-2"><i class="ti ti-caret-down-filled"></i> 9.19%</span>
                                            <span class="text-nowrap">This month</span>
                                        </p>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted fs-13 text-uppercase" title="Number of Orders">Total Programs</h5>
                                        <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1">
                                            <div class="user-img fs-42 flex-shrink-0">
                                                <span class="avatar-title text-bg-primary rounded-circle fs-22">
                                                    <iconify-icon icon="solar:bill-list-bold-duotone"></iconify-icon>
                                                </span>
                                            </div>
                                            <h3 class="mb-0 fw-bold">number</h3>
                                        </div>
                                        <p class="mb-0 text-muted">
                                            <span class="text-success me-2"><i class="ti ti-caret-up-filled"></i> 26.87%</span>
                                            <span class="text-nowrap">All</span>
                                        </p>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted fs-13 text-uppercase" title="Number of Orders">Active Programs</h5>
                                        <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1">
                                            <div class="user-img fs-42 flex-shrink-0">
                                                <span class="avatar-title text-bg-primary rounded-circle fs-22">
                                                    <iconify-icon icon="solar:wallet-money-bold-duotone"></iconify-icon>
                                                </span>
                                            </div>
                                            <h3 class="mb-0 fw-bold">number <small class="text-muted">Ai</small></h3>
                                        </div>
                                        <p class="mb-0 text-muted">
                                            <span class="text-success me-2"><i class="ti ti-caret-up-filled"></i> 3.51%</span>
                                            <span class="text-nowrap">Since </span>
                                        </p>
                                    </div>
                                </div>
                            </div><!-- end col -->

                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted fs-13 text-uppercase" title="Number of Orders">Online  Users</h5>
                                        <div class="d-flex align-items-center justify-content-center gap-2 my-2 py-1">
                                            <div class="user-img fs-42 flex-shrink-0">
                                                <span class="avatar-title text-bg-primary rounded-circle fs-22">
                                                    <iconify-icon icon="solar:eye-bold-duotone"></iconify-icon>
                                                </span>
                                            </div>
                                            <h3 class="mb-0 fw-bold">numberM</h3>
                                        </div>
                                        <p class="mb-0 text-muted">
                                            <span class="text-danger me-2"><i class="ti ti-caret-down-filled"></i> 1.05%</span>
                                            <span id="current-datetime" class="text-nowrap"></span>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function updateDateTime() {
        const now = new Date();
        const options = {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
        };
        document.getElementById('current-datetime').textContent =
            'Since ' + now.toLocaleString('en-US', options);
    }

    updateDateTime();
    setInterval(updateDateTime, 1000); // update every second
});
</script>
                                        </p>
                                    </div>
                                </div>
                            </div><!-- end col -->
                        </div><!-- end row -->

                      

                        <div class="card-header border-bottom border-dashed d-flex align-items-center">
    <h4 class="header-title">Registered Agents</h4>
</div>
<div class="card-body">
    <p class="text-muted">
        Below is a list of all agents currently registered in the system.
    </p>
    <div class="table-responsive-sm">
        <table id="agentsTable" class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Profile</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Campus</th>
                    <th>Role</th>
                    <th>Last Login</th>
                    
                </tr>
            </thead>
            <tbody>
                @forelse($agents as $index => $a)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($a->profile)
                                <img src="{{ asset('storage/' . $a->profile) }}" alt="profile"
                                    class="me-2 avatar-sm rounded-circle" />
                            @else
                                <img src="{{ asset('assets/images/users/default-avatar.png') }}"
                                    alt="default" class="me-2 avatar-sm rounded-circle" />
                            @endif
                        </td>
                        <td>{{ $a->name }}</td>
                        <td>{{ $a->email }}</td>
                        <td>{{ $a->phone }}</td>
                        <td>
                            <span class="badge {{ $a->status === 'Active' ? 'bg-success' : 'bg-danger' }}">
                                {{ $a->status }}
                            </span>
                        </td>
                        <td>{{ $a->campus ?? 'N/A' }}</td>
                        <td>{{ ucfirst($a->role ?? 'N/A') }}</td>
                        <td>{{ $a->login_time ? $a->login_time->format('d M Y, h:i A') : 'Never' }}</td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">No agents found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div> <!-- end table-responsive-->
</div>


                    </div> <!-- end col-->

                   
                </div> <!-- end row-->

            </div> <!-- container -->

            <!-- Footer Start -->
 


