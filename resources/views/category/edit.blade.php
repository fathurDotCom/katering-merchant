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
                                <span class="card-label fw-bold fs-3 mb-1">Form Edit</span>
                                <span class="text-muted mt-1 fw-semibold fs-7">Edit Category</span>
                            </div>
                        </div>
                        <form id="form-input" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('category.update', $data->uuid) }}" method="POST" novalidate="novalidate">
                            @csrf
                            <div class="card-body p-9">
                                    
                                <div class="row mb-8">
                                    <div class="col-xl-3 text-end">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Company</div>
                                    </div>
                                    <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                        <select class="form-select @error('company_uuid') is-invalid @enderror" name="company_uuid" id="company_uuid" data-control="select2" data-placeholder="Select an option">
                                            <option></option>
                                            @foreach ($companies as $item)
                                                <option value="{{ $item->uuid }}" {{ $data->company_uuid ? 'selected' : null }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('company_uuid')
                                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row mb-8">
                                    <div class="col-xl-3 text-end">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Category Name</div>
                                    </div>
                                    <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="example category name" value="{{ $data->name }}">
                                        @error('name')
                                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-xl-3 text-end">
                                        <div class="fs-6 fw-semibold mt-2 mb-3">Status</div>
                                    </div>
                                    <div class="col-xl-9">
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ $data->is_active ? 'checked' : null }}>
                                            <label class="form-check-label fw-semibold text-gray-500 ms-3" for="is_active">Active</label>
                                        </div>
                                    </div>
                                </div>
                                  
                            </div>
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a href="{{ route('category.index') }}" class="btn btn-light btn-active-light-primary btn-sm me-2">back</a>
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
        
        $(document).on('change', '#company_uuid', (e) => {
            let self = $(e.currentTarget)

            $.ajax({
                url: "{{ route('master.company') }}",
                method: 'GET',
                data: {
                    company_uuid: self.val(),
                },
                success: (response) => {
                    
                }
            })
        })

    </script>
@endpush

            