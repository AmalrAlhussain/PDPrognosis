@extends('website.parts.dash')

@section('content')
    <div class="container mt-5">
        <!-- Header Section -->
        <div class="text-center mb-5">
            <h2 class="font-weight-bold text-primary">Latest Parkinson Research</h2>
            <p class="text-muted">Explore cutting-edge studies and insights on Parkinson's disease, updated in real time.</p>
        </div>

        <!-- Research Articles Section -->
        <div class="row">
            @if(!empty($researchArticles))
                @foreach ($researchArticles as $research)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-lg border-0 rounded-lg h-100 hover-effect">
                            <div class="card-body d-flex flex-column">
                                <!-- Title -->
                                <h5 class="card-title font-weight-bold text-primary mb-2 text-truncate" title="{{ $research['title'] }}">
                                    {{ $research['title'] }}
                                </h5>

                                <!-- Published Date -->
                                <p class="text-muted mb-1">
                                    <i class="fa fa-calendar-alt text-secondary mr-1"></i>
                                    <small>Published: <span class="font-italic">{{ $research['published_date'] }}</span></small>
                                </p>

                                <!-- Source -->
                                <p class="text-muted mb-3">
                                    <i class="fa fa-book text-secondary mr-1"></i>
                                    <small>Source: <span class="font-italic">{{ $research['source'] }}</span></small>
                                </p>

                                <!-- Excerpt -->
                                <p class="text-dark small mb-4 flex-grow-1">
                                    Explore the latest advancements and findings in Parkinson’s research. Stay informed about the breakthroughs and developments from trusted medical journals.
                                </p>
                            </div>

                            <!-- Footer with Button -->
                            <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                                <span class="badge badge-primary">#Parkinson</span>
                                <a href="{{ $research['url'] }}" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="fa fa-external-link-alt"></i> Read More
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Empty State -->
                <div class="col-12">
                    <div class="alert alert-info text-center shadow-sm">
                        <i class="fa fa-info-circle fa-2x mb-2 text-primary"></i>
                        <p class="mb-0">No research articles available at the moment. Check back later for updates.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .hover-effect {
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }
        .hover-effect:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
        }
        .card-title {
            line-height: 1.4;
        }
        .badge-primary {
            background-color: #007bff;
            color: #fff;
        }
        .badge-primary:hover {
            background-color: #0056b3;
        }
        .btn-primary {
            border-radius: 20px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .card-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
        .alert-info {
            border-left: 5px solid #007bff;
        }
    </style>
@endsection
