<!-- Home Popup Section -->
<div class="modal fade subscribe_popup" id="onload-popup" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                </button>
                <div class="row g-0">
                    <div class="col-sm-5">
                    	<div class="background_bg h-100">
                            <img src="" alt="" id="showImage">
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="popup_content">
                            <div class="popup-text">
                                <div class="heading_s1">
                                    <h4 id="title_popup" class="fs-4"></h4>
                                </div>
                                <p id="short_des_popup"></p>
                            </div>
                            <form id="subscribe_form">
                            	<div class="form-group mb-3">
                                	<input name="email" required type="email" class="form-control rounded-0" placeholder="Enter Your Email" autocomplete>
                                </div>
                                <div class="form-group mb-3">
                                	<button type="submit" class="btn btn-fill-line btn-block text-uppercase rounded-0" title="Subscribe">Subscribe</button>
                                </div>
                            </form>
                            <div class="chek-form">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value="">
                                    <label class="form-check-label" for="exampleCheckbox3"><span>Don't show this popup again!</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    	</div>
    </div>
</div>
<!-- End Screen Load Popup Section --> 
@push('scripts')
<script>
    (async () => {
        try {
            let res = await axios.get('/popup-show');
            // console.log(res.data);
            if (res.status == 200) {
                if (res.data != '') {
                    document.getElementById('showImage').src = 'storage/'+res.data.image;
                    document.getElementById('title_popup').innerHTML = res.data.title;
                    document.getElementById('short_des_popup').innerHTML = res.data.short_des;
                    // $('#onload-popup').modal('show');
                }
            }
        } catch (error) {
            console.log(error);
        }
    })()

        document.getElementById('subscribe_form').addEventListener('submit', async function(e){
            e.preventDefault();
            let email = document.getElementsByName('email')[0].value;
            // alert(email);
            try {
                let res = await axios.post('/subscribe', {email: email});
                console.log(res);
                if(res.status == 200){
                    document.getElementsByName('email')[0].value = '';
                    //close or hide modal
                    $('#onload-popup').modal('hide');
                    //sweet alert
                    Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Subscribed Successfully",
                    showConfirmButton: false,
                    timer: 1500
                    });
                } else {
                    // alert('You are already subscribed');
                    document.getElementsByName('email')[0].value = '';
                    $('#onload-popup').modal('hide');
                    //sweet alert
                    Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "You are already subscribed",
                    showConfirmButton: false,
                    timer: 1500
                    });
                }
            } catch (error) {
                console.log(error.response.data.message);
                $('#onload-popup').modal('hide');
                    //sweet alert
                    Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "You are already subscribed",
                    showConfirmButton: false,
                    timer: 1500
                    });
            }
        });
    </script>
@endpush