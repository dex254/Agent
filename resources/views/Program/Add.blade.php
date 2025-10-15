@include('Agent.Dashboard.header')

<div class="page-content">

            <div class="page-container">

  <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom border-dashed d-flex align-items-center">
                                <h4 class="header-title">Add  Programs  </h4>
                            </div>

                            <div class="card-body">
                                <p class="text-muted">
    By adding the <code>programs</code> to the table, you help train our AI agent to provide clients with accurate, AI-generated information and insights.
</p>
<form action="{{ route('Program.Post') }}" method="POST">
@csrf
                                    

    <div class="row g-2">
        <div class="mb-3 col-md-6">
            <label for="program_name" class="form-label">Program Name</label>
            <input type="text" name="program_name" id="program_name" class="form-control" placeholder="Enter program name" required>
        </div>
        <div class="mb-3 col-md-6">
            <label for="program_code" class="form-label">Program Code</label>
            <input type="text" name="program_code" id="program_code" class="form-control" placeholder="Enter program code" required>
        </div>
    </div>

    <div class="row g-2">
        <div class="mb-3 col-md-12">
    <label class="form-label d-block">Campus</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="campus" id="campus_lower_kabete" value="Lower Kabete" required>
        <label class="form-check-label" for="campus_lower_kabete">Lower Kabete</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="campus" id="campus_baringo" value="Baringo">
        <label class="form-check-label" for="campus_baringo">Baringo</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="campus" id="campus_mombasa" value="Mombasa">
        <label class="form-check-label" for="campus_mombasa">Mombasa</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="campus" id="campus_embu" value="Embu">
        <label class="form-check-label" for="campus_embu">Embu</label>
    </div>

    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="campus" id="campus_elearning" value="e-Learning and Development Institute">
        <label class="form-check-label" for="campus_elearning">e-Learning and Development Institute</label>
    </div>
</div>

        <div class="mb-3 col-md-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="mb-3 col-md-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>
    </div>
<div class="mb-3 col-md-3">
        <label for="amount" class="form-label">Program Fee (KES)</label>
        <div class="input-group">
            <span class="input-group-text">KES</span>
            <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount" min="0" step="0.01" required>
        </div>
        <small class="text-muted">Enter the total fee for this program.</small>
    </div>
    

    <div class="mb-3 col-md-6">
        {{-- <label for="created_by" class="form-label">Created By</label> --}}
        <input type="hidden" name="created_by" id="created_by" class="form-control" value=" {{ Auth::guard('agent')->user()->securitykey}}" readonly>
    </div>


                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </form>
                            </div> <!-- end card-body -->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>



            </div></div>
 


@include('Agent.Dashboard.footer')