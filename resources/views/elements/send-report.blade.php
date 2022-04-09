<div class="modal fade" id="send_report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="width: 100%; height: auto !important">
            <div class="modal-header">
                <div class="fs-1 fw-boldest">Legalpedia Report</div>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-2x">
                        <i class="mdi mdi-close"></i>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y mt-4 mb-4">
                <div class="container">
                    <div class="row justify-content-center">
                      <div class="col-12">
                        <form class="tab-content pb-4" id="wizardSteps" action="{{route('send.report')}}" method="POST">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="text-center">
                                    <p class="mb-5 text-muted">Please whatever issue you are facing now. We listen and get it fixed immediately.</p>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <label class="form-label mb-1">
                                    Name
                                </label>
                                <input type="hidden" name="name" value="{{Auth::user()->name}} {{Auth::user()->surname}}">
                            </div> --}}
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Email
                                </label>
                                <input type="hidden" name="name" value="{{Auth::user()->name}} {{Auth::user()->surname}}">
                                <input type="hidden" name="to_email" value="legalpediareports@gmail.com">
                                <input type="hidden" name="email" class="form-control" value="{{Auth::user()->email}}">
                                <input type="email" class="form-control" value="{{Auth::user()->email}}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label mb-1">
                                    Report
                                </label>
                                <select name="report_type" id="report-type" class="form-select" onchange="showDiv('show_report', 'report_message', this)">
                                    <option value="">Select report</option>
                                    <option value="Cannot find a case report">Cannot find a case report</option>
                                    <option value="Other">Other Issues</option>
                                </select>
                            </div>
                            <div id="show_report" style="display: none">
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        What case?
                                    </label>
                                    <textarea name="report_message" class="form-control" rows="5" placeholder="Enter case"></textarea>
                                </div>
                            </div>
                            <div id="report_message" style="display: none">
                                <div class="form-group">
                                    <label class="form-label mb-1">
                                        What issue?
                                    </label>
                                    <textarea name="other_message" class="form-control" rows="5" placeholder="Enter report"></textarea>
                                </div>
                            </div>
                            <button type="submit" onclick="this.classList.toggle('button--loading')" class="btn button_load text-white w-100 btn-primary">
                                <span class="button__text"><i class="mdi mdi-check"></i> Send</span>
                            </button>
                        </form>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function showDiv(report, message, element)
        {
            document.getElementById(report).style.display = element.value == 'Cannot find a case report' ? 'block' : 'none';
            document.getElementById(message).style.display = element.value == 'Other' ? 'block' : 'none';
        }

</script>
