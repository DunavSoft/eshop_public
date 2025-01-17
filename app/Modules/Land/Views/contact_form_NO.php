<section class="home-request" id="request">
    <div class="container">
        <h2 class="form-title">{cf_send_question}</h2>
        <form class="row needs-validation" novalidate method="post" action="" id="main-form">
            <div class="col-xxl-5 col-xl-7 col-md-9 ">
                <div class="row g-3">
                    <div class="col-12">
                        <input type="text" class="form-control home-form" name="name" value="" placeholder="{cf_name}"
                               required>
                        <div class="invalid-feedback">
						{cf_insert_name}
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="email" class="form-control home-form" name="email" value="" placeholder="{cf_email}"
                               required>
                        <div class="invalid-feedback">
						{cf_insert_email}
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="tel" class="form-control home-form" name="phone" value="" placeholder="{cf_phone}"
                               required>
                        <div class="invalid-feedback">
						{cf_insert_phone}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row align-items-end" style="margin-top: 20px">
                            <div class="col-xl-8 col-md-9">
                                <p class="form-txt">{cf_design}</p>
                            </div>
                            <div class="col-xl-4 col-md-3">
                                <div class="upload-file">
                                    <label for="formFile" class="form-label" id="filename" style="width: auto">
									{cf_attach}
                                    </label>
                                </div>
                                <input class="form-control"
                                       type="file"
                                       name="file"
                                       id="formFile"
                                       accept="{cf_accept}"
                                       style="max-width: 185px">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <textarea name="job_message" class="form-control home-form"
                                  style="resize: none; height: 220px; border-radius:0"
                                  placeholder="{cf_description}"></textarea>

                    </div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-default btn-home-subbmit" type="submit">{cf_send}</button>
            </div>
        </form>
    </div>
</section>