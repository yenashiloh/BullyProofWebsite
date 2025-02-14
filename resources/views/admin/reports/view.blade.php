<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>View Report</title>

    @include('partials.admin-link')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>
<style>
    .navigation-btn {
        z-index: 1051;
        width: 50px;
        height: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 10px;
    }

    #prevImage {
        left: 10px;
    }

    #nextImage {
        right: 10px;
    }

    .gallery-image:hover {
        transform: scale(1.05);
        transition: transform 0.2s;
    }

    #galleryViewer {
        opacity: 0;
        transition: opacity 0.3s;
    }

    #galleryViewer.show {
        opacity: 1;
    }

    #galleryViewer.d-none {
        display: none;
    }

    #closeGallery {
        position: relative;
        z-index: 1052;
    }
</style>

<body>

    <div id="loading-overlay">
        <img id="loading-logo" src="{{ asset('assets/img/logo-4.png') }}" alt="Loading Logo">
        <div class="spinner"></div>
    </div>

    @include('partials.admin-sidebar')
    @include('partials.admin-header')
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <!-- jQuery (required for Toastr) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Incident Reports</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>

                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.reports.incident-reports') }}">Incident Reports</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item fw-bold">
                        <a href="">View Report</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h4 class="card-title">View Report</h4>
                        </div> --}}
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-line nav-color-secondary" id="line-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="line-home-tab" data-bs-toggle="pill"
                                        href="#line-home" role="tab" aria-controls="pills-home"
                                        aria-selected="true">Complainant's Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="line-profile-tab" data-bs-toggle="pill" href="#line-profile"
                                        role="tab" aria-controls="pills-profile" aria-selected="false">Complainee's
                                        Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="line-contact-tab" data-bs-toggle="pill" href="#line-contact"
                                        role="tab" aria-controls="pills-contact" aria-selected="false">Incident
                                        Details</a>
                                </li>
                            </ul>

                            <!-- Victim's Information -->
                            <div class="tab-content mt-3 mb-3" id="line-tabContent">
                                <div class="tab-pane fade show active" id="line-home" role="tabpanel"
                                    aria-labelledby="line-home-tab">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="mb-2 mt-2"><strong>Reported Date and Time:</strong></label>
                                            <input type="text" class="form-control"
                                                value="{{ \Carbon\Carbon::parse($reportData['reportDate'])->setTimezone('Asia/Manila')->format('F j, Y, g:i A') }}"
                                                disabled>
                                        </div>
                                        
                                        <div class="col-md-6 mb-2">
                                            <label class="mb-2 mt-2"><strong>Relationship to Victim:</strong></label>
                                            <input type="text" class="form-control" value="{{ $reportData['victimRelationship'] }}" disabled>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="mb-2 mt-2"><strong>Full Name:</strong></label>
                                            <input type="text" class="form-control"
                                                value="{{ $reportData['victimName'] }}" disabled>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="mb-2 mt-2"><strong>Year Level or
                                                    Position:</strong></label>
                                            <input type="text" class="form-control"
                                                value="{{ $reportData['gradeYearLevel'] }}" disabled>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="mb-2 mt-2"><strong>Role in the
                                                    University:</strong></label>
                                            <input type="text" class="form-control"
                                                value="{{ $reportData['victimType'] }}" disabled>
                                        </div>
                                       
                                    </div>
                                </div>

                                <!-- Complainee's Information -->
                                <div class="tab-pane fade" id="line-profile" role="tabpanel"
                                    aria-labelledby="line-profile-tab">
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="mb-2 mt-2"><strong>Full Name:</strong></label>
                                            <input type="text" class="form-control"
                                                value="{{ $reportData['perpetratorName'] }}" disabled>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="mb-2 mt-2"><strong>Role in the University:</strong></label>
                                            <input type="text" class="form-control"
                                                value="{{ $reportData['perpetratorRole'] }}" disabled>
                                        </div>
                                    </div>

                                    <form id="updateReportForm" method="POST"
                                        action="{{ route('admin.updateReport') }}" class="mb-0">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label class="mb-2 mt-2"><strong>Grade/Year Level or
                                                        Position:</strong></label>
                                                <input type="text" class="form-control"
                                                    value="{{ $reportData['perpetratorGradeYearLevel'] }}" disabled>
                                            </div>
                                            <div class="col-md-6 mb-2 position-relative">
                                                <label class="mb-2 mt-2"><strong>ID Number</strong></label>
                                                <div class="input-group">
                                                    <input type="text" name="id_number" id="id_number"
                                                        class="form-control" value="{{ $reportData['idNumber'] }}"
                                                        required autocomplete="off">
                                                    <div id="idNumberSuggestions" class="list-group"
                                                        style="z-index: 1000; display: none; max-height: 200px; overflow-y: auto; background-color: #f8f9fa; border: 1px solid #8f8f8f; border-radius: 0.375rem;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <label class="mb-2 mt-2"><strong>Remarks</strong></label>
                                        <div class="input-group">
                                            <textarea name="remarks" class="form-control" rows="4">{{ $reportData['remarks'] }}</textarea>
                                        </div>

                                        <input type="hidden" name="report_id" value="{{ $reportData['_id'] }}"
                                            required>

                                        <button type="submit" class="btn btn-secondary mt-3"
                                            id="saveButton">Save</button>
                                    </form>

                                    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3"
                                        style="z-index: 1050;"></div>

                                </div>

                                <!-- Incident Details -->
                                <div class="tab-pane fade" id="line-contact" role="tabpanel"
                                    aria-labelledby="line-contact-tab">
                                    <div class="row">
                                        @if (empty($reportData['describeActions']) && empty($reportData['reportedTo']))
                                            <div class="col-md-6 mb-2">
                                                <label class="mb-2 mt-2"><strong>Have actions been taken so
                                                        far:</strong></label>
                                                <input type="text" class="form-control"
                                                    value="{{ $reportData['actionsTaken'] }}" disabled>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label class="mb-2 mt-2"><strong>Have Reported the Incident to Anyone
                                                        Else:</strong></label>
                                                <input type="text" class="form-control"
                                                    value="{{ $reportData['hasReportedBefore'] }}" disabled>
                                            </div>
                                        @else
                                            <div class="col-md-6 mb-2">
                                                <label class="mb-2 mt-2"><strong>Have actions been taken so
                                                        far:</strong></label>
                                                <input type="text" class="form-control"
                                                    value="{{ $reportData['actionsTaken'] }}" disabled>
                                            </div>
                                            @if (!empty($reportData['describeActions']))
                                                <div class="col-md-6 mb-2">
                                                    <label class="mb-2 mt-2"><strong>Describe Actions:</strong></label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $reportData['describeActions'] }}" disabled>
                                                </div>
                                            @endif

                                            <div class="col-md-6 mb-2">
                                                <label class="mb-2 mt-2"><strong>Have Reported the Incident to Anyone
                                                        Else:</strong></label>
                                                <input type="text" class="form-control"
                                                    value="{{ $reportData['hasReportedBefore'] }}" disabled>
                                            </div>
                                            @if (!empty($reportData['reportedTo']))
                                                <div class="col-md-6 mb-2">
                                                    <label class="mb-2 mt-2"><strong>Reported to:</strong></label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $reportData['reportedTo'] }}" disabled>
                                                </div>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mb-2 mt-3">
                                            <strong>Platform where cyberbullying occurred:</strong>
                                        </div>
                                        <div class="col-12">
                                            @foreach ($reportData['platformUsed'] as $platform)
                                                <div class="mb-2">
                                                    <input type="text" class="form-control" value="{{ $platform }}" disabled>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-12 mb-2 mt-3">
                                            <strong>Support Types:</strong>
                                        </div>
                                        <div class="col-12">
                                            @foreach ($reportData['supportTypes'] as $supportType)
                                                <div class="mb-2">
                                                    <input type="text" class="form-control" value="{{ $supportType }}" disabled>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-12 mb-2 mt-3">
                                            <strong>Incident Details:</strong>
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form-control" rows="10" disabled>{{ $reportData['incidentDetails'] }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 mb-2 mt-3">
                                            <strong>Incident Evidence:</strong>
                                        </div>
                                        <div class="col-12">
                                            @if (!empty($reportData['incidentEvidence']))
                                                <div class="d-flex flex-wrap">
                                                    @foreach ($reportData['incidentEvidence'] as $index => $base64Image)
                                                        <div class="m-2">
                                                            <img src="data:image/jpeg;base64,{{ $base64Image }}"
                                                                alt="Incident Evidence"
                                                                class="img-fluid img-thumbnail gallery-image"
                                                                style="width: 150px; height: 150px; object-fit: cover; cursor: pointer;"
                                                                data-gallery-index="{{ $index }}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p>No incident evidence available.</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Full Screen Image Viewer -->
                                    <div id="galleryViewer"
                                        class="position-fixed top-0 start-0 w-100 h-100 bg-black d-none"
                                        style="z-index: 1050;">
                                        <div class="position-absolute top-0 end-0 p-3">
                                            <button type="button" class="btn btn-light" id="closeGallery">
                                                <span>&times;</span>
                                            </button>
                                        </div>

                                        <div
                                            class="d-flex justify-content-center align-items-center h-100 position-relative">
                                            <button
                                                class="btn btn-light navigation-btn position-absolute start-0 top-50 translate-middle-y"
                                                id="prevImage" style="display: none;">&lt;</button>

                                            <div class="d-flex justify-content-center align-items-center"
                                                style="height: 90vh;">
                                                <img id="fullImage" src="" alt="Full Size Image"
                                                    style="max-height: 90vh; max-width: 80vw; object-fit: contain;">
                                            </div>

                                            <button
                                                class="btn btn-light navigation-btn position-absolute end-0 top-50 translate-middle-y"
                                                id="nextImage" style="display: none;">&gt;</button>
                                        </div>
                                    </div>



                                    <hr>
                                    <div class="result">
                                        @if (isset($reportData['analysisResult']))
                                            <h5 class="text-lg font-semibold mb-2 fw-bold">Cyberbullying Analysis</h5>
                                            <p class="mb-2">
                                                <span class="font-medium">Result:</span>
                                                <span
                                                    class="@if ($reportData['analysisResult'] === 'Cyberbullying Detected') text-danger @else text-success @endif">
                                                    {{ $reportData['analysisResult'] }}
                                                </span>
                                            </p>
                                            <p>
                                                <span class="font-medium">Probability:</span>
                                                <span
                                                    class="@if ($reportData['analysisProbability'] > 50) text-danger @else text-success @endif">
                                                    {{ number_format($reportData['analysisProbability'], 2) }}%
                                                </span>
                                            </p>
                                        @else
                                            <div class="bg-yellow-50 p-4 rounded-lg shadow mb-4">
                                                <p class="text-yellow-700">Analysis result not available</p>
                                            </div>
                                        @endif

                                        @if (isset($reportData['error']))
                                            <div class="bg-red-50 p-4 rounded-lg shadow">
                                                <p class="text-red-700">Error: {{ $reportData['error'] }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('partials.admin-footer')
    <script>
        window.galleryImages = @json($reportData['incidentEvidence'] ?? []);
    </script>
    <script src="../../../../assets/js/report.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        // Function to show custom toast notifications
        function showToast(message, type) {
            const toastElement = document.createElement('div');
            toastElement.classList.add('toast', 'align-items-center', 'text-white', 'bg-' + type, 'border-0');
            toastElement.setAttribute('role', 'alert');
            toastElement.setAttribute('aria-live', 'assertive');
            toastElement.setAttribute('aria-atomic', 'true');

            toastElement.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;

            const toastContainer = document.getElementById('toastContainer');
            toastContainer.appendChild(toastElement);

            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }

        $(document).ready(function() {
            $('#updateReportForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Change the button text to "Saving..." and disable it
                $('#saveButton').text('Saving...').prop('disabled', true);

                // Send form data via AJAX
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Show toast with the response message and type
                        showToast(response.message, response.status);

                        // Reset the button text to "Save"
                        $('#saveButton').text('Save').prop('disabled', false);
                    },
                    error: function(xhr) {
                        // Show toast with the error message
                        var errorMessage = xhr.responseJSON.message ||
                            'An error occurred while saving the report.';
                        showToast(errorMessage, 'error');

                        // Reset the button text to "Save"
                        $('#saveButton').text('Save').prop('disabled', false);
                    }
                });
            });
        });

        $(document).ready(function() {
            const inputField = $('#id_number');
            const suggestionsContainer = $('#idNumberSuggestions');

            inputField.on('input', function() {
                const searchTerm = $(this).val();

                if (searchTerm.length >= 3) { // Trigger after 3 characters
                    $.ajax({
                        url: '{{ route('search.idNumber') }}',
                        method: 'GET',
                        data: {
                            term: searchTerm
                        },
                        success: function(data) {
                            // Remove duplicates using Set
                            const uniqueData = [...new Set(data)];

                            // Clear and reposition suggestions
                            suggestionsContainer.empty().hide();

                            if (uniqueData.length > 0) {
                                // Match width of input field
                                suggestionsContainer.css({
                                    width: inputField.outerWidth() + 'px',
                                    top: inputField.outerHeight() + 'px',
                                    left: inputField.position().left + 'px',
                                    position: 'absolute'
                                });

                                // Append suggestions
                                uniqueData.forEach(function(idNumber) {
                                    suggestionsContainer.append(`
                                    <a href="#" class="list-group-item list-group-item-action">${idNumber}</a>
                                `);
                                });

                                // Show the dropdown
                                suggestionsContainer.show();

                                // Add click event to suggestions
                                suggestionsContainer.find('a').on('click', function(e) {
                                    e.preventDefault();
                                    inputField.val($(this).text());
                                    suggestionsContainer.empty().hide();
                                });
                            }
                        }
                    });
                } else {
                    suggestionsContainer.empty().hide();
                }
            });

            // Hide suggestions if the user clicks outside the input or suggestions
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#id_number, #idNumberSuggestions').length) {
                    suggestionsContainer.empty().hide();
                }
            });
        });
    </script>
