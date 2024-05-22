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
                                <span class="text-muted mt-1 fw-semibold fs-7">Add New Product</span>
                            </div>
                        </div>
                        <form id="form-input" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" novalidate="novalidate">
                            @csrf
                            <div class="card-body p-9">

                                <div class="row">
                                    
                                    <div class="col-xl-6">
                                        
                                        <div class="row mb-8">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Company <span class="required"></span></div>
                                            </div>
                                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                                <select class="form-select @error('company_uuid') is-invalid @enderror" name="company_uuid" id="company_uuid" data-allow-clear="true" data-control="select2" data-placeholder="Select an option" required>
                                                    <option></option>
                                                    @foreach ($companies as $item)
                                                        <option value="{{ $item->uuid }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('company_uuid')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-8">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Category</div>
                                            </div>
                                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                                <select class="form-select @error('category_uuid') is-invalid @enderror" name="category_uuid" id="category_uuid" data-allow-clear="true" data-control="select2" data-placeholder="Select an option">
                                                    <option></option>
                                                </select>
                                                @error('category_uuid')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-xl-6">
                                        
                                        <div class="row mb-8">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Product Name <span class="required"></span></div>
                                            </div>
                                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="example product name" required>
                                                @error('name')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-8">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Price <span class="required"></span></div>
                                            </div>
                                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                                <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" placeholder="example product price" required>
                                                @error('price')
                                                    <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-8">
                                            <div class="col-xl-3 text-end">
                                                <div class="fs-6 fw-semibold mt-2 mb-3">Description</div>
                                            </div>
                                            <div class="col-xl-9 fv-row fv-plugins-icon-container">
                                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" cols="30" rows="3" placeholder="example description"></textarea>
                                                @error('description')
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
                                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                                    <label class="form-check-label fw-semibold text-gray-500 ms-3" for="is_active">Active</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="fs-6 fw-semibold mt-2 mb-3">Upload Images</div>
                                </div>

                                <div class="row">

                                    <input type="file" name="images[]" class="d-none" id="images">

                                    <div class="dropzone" id="image_drop_js">
                                        <div class="dz-message needsclick">
                                            <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

                                            <div class="ms-4">
                                                <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                                                <span class="fs-7 fw-semibold text-gray-500">Upload up to 10 files</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a href="{{ route('product.index') }}" class="btn btn-light btn-active-light-primary btn-sm me-2">back</a>
                                <button type="submit" class="btn btn-primary btn-sm" id="btn-submit">Save Changes</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
    <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
@endpush

@push('script')
    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script>
        
        $(document).ready(() => {
            
            document.querySelector('#is_active').indeterminate = false;
            
            Inputmask({
                "mask" : "(999) 999-999-9999"
            }).mask("#phone");

            const input = $('#images');
            let list = new DataTransfer();
            
            var myDropzone = new Dropzone("#image_drop_js", {
                url: "{{ route('product.store') }}",
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 10,
                maxFiles: 10,
                init: function() {
                    this.on("addedfile", (file) => {
                        let temp = new File([file], file.name);
                        list.items.add(temp);
                    })
                }
    
            });

            $(document).on('click', '#btn-submit', () => {
                let myFileList = list.files;
                input[0].files = myFileList
            })
        })

        $(document).on('submit', '#form-input', (e) => {
            appSubmit(e)
        })
        
        $(document).on('change', '#company_uuid', (e) => {
            const self = $(e.currentTarget)

            $.ajax({
                url: "{{ route('master.category') }}",
                method: 'GET',
                data: {
                    company_uuid: self.val(),
                },
                success: (response) => {
                    $('#category_uuid').html(response)
                }
            })
        })
        
    </script>
@endpush

            