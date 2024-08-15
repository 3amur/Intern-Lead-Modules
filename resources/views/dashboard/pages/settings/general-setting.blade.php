@extends('dashboard.layouts.app')
@section('title')
    {{ __('General Setting Page') }}
@endsection
@section('css')
    <style>
        .tox-notification.tox-notification--in.tox-notification--warning {
            display: none !important;
        }

        .tox.tox-silver-sink.tox-tinymce-aux {
            display: none !important;
        }
    </style>
@endsection
@section('content')
    <div class="content ">
        <div class="px-2 px-md-5">
            <div class="align-items-start border-bottom">
                <div class="pt-1 w-100 mb-3 d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-2 me-2 lh-sm"><span class="fa-solid fa-sliders me-2 fs-0"></span>General Setting</h5>
                    </div>
                </div>
            </div>

            <!-- general tabs  -->
            <div class="general-setting-tabs py-3">
                <div class="scrollbar">
                    <ul class="nav nav-underline mb-3 pb-1 justify-content-between" id="myTab" role="tablist">
                        <li class="nav-item me-3 flex-grow-1 "><a class="nav-link text-nowrap fs-1 active" id="orders-tab"
                                data-bs-toggle="tab" href="#tab-tab1" role="tab" aria-controls="tab-orders"
                                aria-selected="true"><span class="fa-solid fa-tag me-2"></span>Tab 1</a></li>
                        <li class="nav-item me-3 flex-grow-1"><a class="nav-link text-nowrap  fs-1" id="reviews-ta"
                                data-bs-toggle="tab" href="#tab-tab2" role="tab" aria-controls="tab-orders"
                                aria-selected="true"><span class="fa-solid fa-tag me-2"></span>Tab 2<span
                                    class="text-700 fw-normal"></span></a></li>
                        <li class="nav-item me-3 flex-grow-1"><a class="nav-link text-nowrap  fs-1 " id="stores-tab"
                                data-bs-toggle="tab" href="#tab-tab3" role="tab" aria-controls="tab-stores"
                                aria-selected="true"><span class="fa-solid fa-tag me-2"></span>Tab 3</a></li>
                        <li class="nav-item flex-grow-1"><a class="nav-link text-nowrap  fs-1 " id="personal-info-tab"
                                data-bs-toggle="tab" href="#tab-tab4" role="tab" aria-controls="tab-personal-info"
                                aria-selected="true"><span class="fa-solid fa-tag me-2"></span>Tab 4</a></li>
                    </ul>
                </div>
                <div class="tab-content" id="generalSettingTabs">
                    <!-- tab 1 -->
                    <div class="tab-pane fade active show" id="tab-tab1" role="tabpanel" aria-labelledby="Main-tab">
                        <div class="row g-3 mb-5">
                            <div class="col-12 col-lg-6 col-xl-4"><label
                                    class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2" for="adminTitle">
                                    Title
                                </label><input class="form-control" id="adminTitle" type="text" placeholder="Title" />
                            </div>
                            <div class="col-12 col-lg-6 col-xl-4"><label
                                    class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2" for="metaName">Meta
                                    Name
                                </label><input class="form-control" id="metaName" type="text" placeholder="Meta" />
                            </div>
                            <div class="col-12 col-lg-6 col-xl-4"><label
                                    class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2" for="metaTitle">Meta
                                    Title</label><input class="form-control" id="metaTitle" type="text"
                                    placeholder="Meta" /></div>
                            <div class="col-12 col-lg-6 col-xl-4"><label
                                    class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2" for="metaDes">Meta
                                    Description</label><input class="form-control" id="metaDes" type="text"
                                    placeholder="Meta" />
                            </div>
                            <div class="col-12 col-lg-12 col-xl-4"><label
                                    class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2"
                                    for="mainAdminLogo">Main Admin
                                    Logo</label><input class="form-control" id="mainAdminLogo" type="file" /></div>
                        </div>
                        <div class="text-sm-end text-center"><button class="btn btn-primary px-7">Save changes</button>
                        </div>

                    </div>
                    <!-- tab 2 -->
                    <div class="tab-pane fade" id="tab-tab2" role="tabpanel" aria-labelledby="wishlist-tab">
                        <div class="row g-3 mb-5">
                            <div class="col-12 col-lg-12">
                                <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm" for="Access-Type">Access
                                    Type</label><select class="form-select" id="Access-Type" data-choices="data-choices"
                                    data-options='{"removeItemButton":true,"placeholder":true}'>
                                    <option value="">Select type...</option>
                                    <option>Email</option>
                                    <option>Phone</option>
                                    <option>Username</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">

                                <div class=" d-flex align-items-center  justify-content-between mt-2">
                                    <label class="form-label text-1000 fs-0 ps-0 pe-3 text-capitalize lh-sm mt-1"
                                        for="Signup ">Signup</label>
                                    <div class="form-check form-switch form-switch-lg ">
                                        <input class="form-check-input" id="Forget-Password" type="checkbox"
                                            checked="" />
                                    </div>
                                </div>
                                <!--  -->

                                <div class="row align-items-center justify-content-between mt-2">
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mt-1"
                                            for="Forget-Password">Forget Password</label>
                                        <div class="form-check form-switch form-switch-lg">
                                            <input class="form-check-input" id="forgetPasswordSwitch" type="checkbox" />
                                        </div>
                                    </div>

                                    <div class="reset-password-setting col-12 d-flex flex-column mt-2 d-none">
                                        <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mt-1">Reset
                                            Password
                                            Options</label>
                                        <div class="w-100 form-check form-check-inline mt-2">
                                            <input class="form-check-input" id="inlineCheckbox1" name="ResetPassword"
                                                type="radio" value="OTP" />
                                            <label class="form-check-label fs-xl-0" for="inlineCheckbox1">OTP</label>
                                        </div>
                                        <div class="w-100 form-check form-check-inline ">
                                            <input class="form-check-input " id="inlineCheckbox2" name="ResetPassword"
                                                type="radio" value="Generated link" />
                                            <label class="form-check-label   fs-0" for="inlineCheckbox2"> Generated link
                                                for rest password
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-sm-end text-center"><button class="btn btn-primary px-7">Save
                                    changes</button></div>
                        </div>

                    </div>

                    <!-- tab 3 -->
                    <div class="tab-pane fade " id="tab-tab3" role="tabpanel" aria-labelledby="wishlist-tab">
                        <div class="px-2 px-md-5">
                            <div class="align-items-start ">
                                <div
                                    class="pt-1 w-100 mb-3 d-flex justify-content-between align-items-start border-bottom pb-2">
                                    <div class="">
                                        <h5 class="mb-2 me-2 lh-sm"><span
                                                class="fa-solid fa-envelopes-bulk me-2 fs-0"></span>SMTP
                                            Setting </h5>
                                    </div>
                                </div>

                                <div class="row g-3 mb-5">
                                    <div class="col-12 col-sm-6 col-lg-4"><label
                                            class="mb-1 form-label text-1000 fs-0 ps-0 text-capitalize lh-sm"
                                            for="smtpMailer">Mailer</label><input class="form-control" id="smtpMailer"
                                            type="text" placeholder="smtp" /></div>
                                    <div class="col-12 col-sm-6 col-lg-4"><label
                                            class="mb-1 form-label text-1000 fs-0 ps-0 text-capitalize lh-sm"
                                            for="mailMailer">Mail
                                            Mailer</label><input class="form-control" id="mailMailer" type="text"
                                            placeholder="smtp@gmail.com" /></div>
                                    <div class="col-12 col-sm-6 col-lg-4"><label
                                            class="mb-1 form-label text-1000 fs-0 ps-0 text-capitalize lh-sm"
                                            for="mailAddress">Mail
                                            Address</label><input class="form-control" id="mailAddress" type="text"
                                            placeholder="example@gmail.com" /></div>
                                    <div class="col-12 col-sm-6 col-lg-4"><label
                                            class="mb-1 form-label text-1000 fs-0 ps-0 text-capitalize lh-sm"
                                            for="smtpMailPassword">Mail
                                            Password</label><input class="form-control" id="smtpMailPassword"
                                            type="password" placeholder="Your Mail Password" /></div>
                                    <div class="col-12 col-sm-6 col-lg-4"><label
                                            class="mb-1 form-label text-1000 fs-0 ps-0 text-capitalize lh-sm"
                                            for="smtpMailName">Mail
                                            Name</label><input class="form-control" id="smtpMailName" type="text"
                                            placeholder="example@gmail.com" /></div>
                                    <div class="col-12 col-sm-6 col-lg-4"><label
                                            class="mb-1 form-label text-1000 fs-0 ps-0 text-capitalize lh-sm"
                                            for="smtpMailAccess">Mail
                                            Port </label><input class="form-control" id="smtpMailAccess" type="text"
                                            placeholder="587" />
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm"
                                            for="smtpMailEncryptionType">Mail Encryption</label><select
                                            class="form-select" id="smtpMailEncryptionType" data-choices="data-choices"
                                            data-options='{"removeItemButton":true,"placeholder":true}'>
                                            <option value="">Select type...</option>
                                            <option>SSL</option>
                                            <option>TLS</option>
                                        </select>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="px-2 px-md-5">
                            <div class="align-items-start ">
                                <div
                                    class="pt-1 w-100 mb-3 d-flex justify-content-between align-items-start border-bottom pb-2">
                                    <div class="">
                                        <h5 class="mb-2 me-2 lh-sm"><span
                                                class="fa-solid fa-envelopes-bulk me-2 fs-0"></span>IMP
                                            Setting </h5>
                                    </div>
                                </div>

                                <div class="row g-3 mb-5">
                                    <div class="col-12 col-sm-6 col-lg-4"><label
                                            class="mb-1 form-label text-1000 fs-0 ps-0 text-capitalize lh-sm"
                                            for="imapProtocol">IMAP
                                            Protocol</label><input class="form-control" id="imapProtocol" type="text"
                                            placeholder="IMAP" /></div>
                                    <div class="col-12 col-sm-6 col-lg-4"><label
                                            class="mb-1 form-label text-1000 fs-0 ps-0 text-capitalize lh-sm"
                                            for="imapHost">IMAP
                                            Host</label><input class="form-control" id="imapHost" type="text"
                                            placeholder="IMAP@gmail.com" /></div>
                                    <div class="col-12 col-sm-6 col-lg-4"><label
                                            class="mb-1 form-label text-1000 fs-0 ps-0 text-capitalize lh-sm"
                                            for="imapPort">IMAP
                                            Port</label><input class="form-control" id="imapPort" type="text"
                                            placeholder="example@gmail.com" /></div>
                                    <div class="col-12 col-sm-6 col-lg-6"><label
                                            class="mb-1 form-label text-1000 fs-0 ps-0 text-capitalize lh-sm"
                                            for="imapPassword">IMAP
                                            Password</label><input class="form-control" id="imapPassword" type="password"
                                            placeholder="Your Mail Password" /></div>
                                    <div class="col-12 col-sm-6 col-lg-6"><label
                                            class="mb-1 form-label text-1000 fs-0 ps-0 text-capitalize lh-sm"
                                            for="imapMailAddress">IMAP
                                            Mail Address</label><input class="form-control" id="imapMailAddress"
                                            type="text" placeholder="example@gmail.com" /></div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm"
                                            for="imapEncryption">IMAP
                                            Encryption</label><select class="form-select" id="imapEncryption"
                                            data-choices="data-choices"
                                            data-options='{"removeItemButton":true,"placeholder":true}'>
                                            <option value="">Select type...</option>
                                            <option>SSL</option>
                                            <option>TLS</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <label class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm"
                                            for="imapValidation">IMAP
                                            Validation Certificate</label><select class="form-select" id="imapValidation"
                                            data-choices="data-choices"
                                            data-options='{"removeItemButton":true,"placeholder":true}'>
                                            <option value="">Select Option...</option>
                                            <option>True</option>
                                            <option>False</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end"><button class="btn btn-primary px-7">Save changes</button></div>
                        </div>
                    </div>
                    <!-- tab 4 -->
                    <div class="tab-pane fade " id="tab-tab4" role="tabpanel" aria-labelledby="personal-info-tab">
                        <div class="px-2 px-md-5">
                            <div class="align-items-start ">
                                <div
                                    class="pt-1 w-100 mb-3 d-flex justify-content-between align-items-start border-bottom pb-2">
                                    <div class="w-100">
                                        <h5 class="mb-2 me-2 lh-sm"><span
                                                class="fa-solid fa-newspaper me-2 fs-0"></span>Template</h5>
                                    </div>
                                </div>
                                <div>
                                    <textarea id="mytextarea">Hello, World!</textarea>
                                    <textarea id="editor">Hello, World!</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- TinyMCE CDN -->
    <!-- <script src="https://cdn.tiny.cloud/1/81klsjbifxyp9wgmcfrawrte9urljfu5fb0br0v4hionhiqn/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script> -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ],
            ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
                "See docs to implement AI Assistant")),
        });
    </script>
@endsection
