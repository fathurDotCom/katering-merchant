@extends('layouts.layout')
@section('title', 'dashboard')
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="row g-5 g-xl-8">
                <div class="col-xl-12">

                    @session('success')
                        <div class="alert alert-success d-flex align-items-center p-5">
                            <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>

                            <div class="d-flex flex-column">
                                <h4 class="mb-1 text-dark">{{ session()->get('error') }}</h4>

                                <span>Data successfully added to the system.</span>
                            </div>
                        </div>
                    @endsession
                    
                    @session('error')
                        <div class="alert alert-danger d-flex align-items-center p-5">
                            <i class="ki-duotone ki-shield-cross fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>

                            <div class="d-flex flex-column">
                                <h4 class="mb-1 text-dark">{{ session()->get('error') }}</h4>

                                <span>Data failed added to the system.</span>
                            </div>
                        </div>
                    @endsession
                    
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title fs-3 fw-bold">
                                <span class="card-label fw-bold fs-3 mb-1">Form Add New</span>
                                <span class="text-muted mt-1 fw-semibold fs-7">Add New Company</span>
                            </div>
                        </div>
                        <form id="form-input" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                            @csrf
                            <div class="card-body p-9">

                                <div class="row">

                                    <div class="col-xl-6">  
                                        
                                        <div class="row mb-5">
    
                                            <div class="col-xl-3"></div>

                                            <div class="col-xl-3 text-center">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Logo Light</div>
                                                
                                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('/assets/media/svg/avatars/blank.svg')">
                                                    <div class="image-input-wrapper w-125px h-125px bgi-position-center" style="background-size: 75%; background-image: url('/assets/media/svg/brand-logos/volicity-9.svg')"></div>
                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change logo light" data-bs-original-title="Change logo light" data-kt-initialized="1">
                                                        <i class="ki-duotone ki-pencil fs-7">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <input type="file" name="logo_light" accept=".png, .jpg, .jpeg">
                                                        <input type="hidden" name="logo_light_remove">
                                                    </label>
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel logo light" data-bs-original-title="Cancel logo light" data-kt-initialized="1">
                                                        <i class="ki-duotone ki-cross fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </span>
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove logo light" data-bs-original-title="Remove logo light" data-kt-initialized="1">
                                                        <i class="ki-duotone ki-cross fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </span>
                                                </div>
                                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                @error('logo_light')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        
                                            <div class="col-xl-3 text-center">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Logo Dark</div>
                                                
                                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('/assets/media/svg/avatars/blank.svg')">
                                                    <div class="image-input-wrapper w-125px h-125px bgi-position-center" style="background-size: 75%; background-image: url('/assets/media/svg/brand-logos/volicity-9.svg')"></div>
                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change logo dark" data-bs-original-title="Change logo dark" data-kt-initialized="1">
                                                        <i class="ki-duotone ki-pencil fs-7">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <input type="file" name="logo_dark" accept=".png, .jpg, .jpeg">
                                                        <input type="hidden" name="logo_dark_remove">
                                                    </label>
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel logo dark" data-bs-original-title="Cancel logo dark" data-kt-initialized="1">
                                                        <i class="ki-duotone ki-cross fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </span>
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove logo dark" data-bs-original-title="Remove logo dark" data-kt-initialized="1">
                                                        <i class="ki-duotone ki-cross fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </span>
                                                </div>
                                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                @error('logo_dark')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        
                                            <div class="col-xl-3 text-center">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Favicon</div>
        
                                                <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('/assets/media/svg/avatars/blank.svg')">
                                                    <div class="image-input-wrapper w-125px h-125px bgi-position-center" style="background-size: 75%; background-image: url('/assets/media/svg/brand-logos/volicity-9.svg')"></div>
                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" aria-label="Change favicon" data-bs-original-title="Change favicon" data-kt-initialized="1">
                                                        <i class="ki-duotone ki-pencil fs-7">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <input type="file" name="favicon" accept=".png, .jpg, .jpeg">
                                                        <input type="hidden" name="favicon_remove">
                                                    </label>
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" aria-label="Cancel favicon" data-bs-original-title="Cancel favicon" data-kt-initialized="1">
                                                        <i class="ki-duotone ki-cross fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </span>
                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" aria-label="Remove favicon" data-bs-original-title="Remove favicon" data-kt-initialized="1">
                                                        <i class="ki-duotone ki-cross fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </span>
                                                </div>
                                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                @error('favicon')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                                
                                        </div>

                                        <div class="row mb-8">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Company Name</div>
                                            </div>
                                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="example company name">
                                                @error('name')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-8">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Phone</div>
                                            </div>
                                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="(999) 999-999-9999">
                                                @error('phone')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
        
                                        <div class="row mb-8">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Email</div>
                                            </div>
                                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="example@email.com">
                                                @error('email')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-8">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Address</div>
                                            </div>
                                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" cols="30" rows="3" placeholder="example address"></textarea>
                                                @error('address')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Status</div>
                                            </div>
                                            <div class="col-xl-9">
                                                <div class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                                    <label class="form-check-label fw-semibold text-gray-500 ms-3" for="is_active">Active</label>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>

                                    <div class="col-xl-6">

                                        <div class="row mb-8">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Url</div>
                                            </div>
                                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                                <input type="text" class="form-control @error('url') is-invalid @enderror" name="url" placeholder="http://example.url.com/">
                                                @error('url')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-8">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Facebook</div>
                                            </div>
                                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                                <input type="text" class="form-control @error('facebook') is-invalid @enderror" name="facebook" placeholder="example url facebook">
                                                @error('facebook')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-8">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Instagram</div>
                                            </div>
                                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                                <input type="text" class="form-control @error('instagram') is-invalid @enderror" name="instagram" placeholder="example url instagram">
                                                @error('instagram')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-8">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Youtube</div>
                                            </div>
                                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                                <input type="text" class="form-control @error('youtube') is-invalid @enderror" name="youtube" placeholder="example url youtube">
                                                @error('youtube')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-8">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Twitter</div>
                                            </div>
                                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                                <input type="text" class="form-control @error('twitter') is-invalid @enderror" name="twitter" placeholder="example url twitter">
                                                @error('twitter')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a href="{{ route('company.index') }}" class="btn btn-light btn-active-light-primary btn-sm me-2">back</a>
                                <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        $(document).ready(() => {
            
            document.querySelector('#is_active').indeterminate = false;
            
            Inputmask({
                "mask" : "(999) 999-999-9999"
            }).mask("#phone");
        })
        
        $(document).on('submit', '#form-input', (e) => {
            appSubmit(e)
        })

    </script>
@endpush

            