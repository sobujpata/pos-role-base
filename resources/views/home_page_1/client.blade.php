<!-- START SECTION TESTIMONIAL -->
<div class="section bg_redon">
	<div class="container">
    	<div class="row justify-content-center">
        	<div class="col-md-6">
            	<div class="heading_s1 text-center">
                	<h2 class="fs-2">Our Client Say!</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-9">
            	<div id="clientSlide" class="testimonial_wrap testimonial_style1 owl-carousel owl-theme">
                	<!-- Ajax data will be appended here -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION TESTIMONIAL -->

@push('scripts')
<script>
    

    async function getClient(){
        let res = await axios.get('/client-show');
        if(res.status == 200){
            let slider = $("#clientSlide");

            res.data.forEach(element => {
                let clients = `
                    <div class="testimonial_box">
                    	<div class="testimonial_desc">
                        	<p>${element.short_des}</p>
                        </div>
                        <div class="author_wrap">
                            <div class="author_img">
                                <img src="${element.image}" alt="${element.name}" />
                            </div>
                            <div class="author_name">
                                <h6>${element.name}</h6>
                                <span>${element.designation}</span>
                            </div>
                        </div>
                    </div>
                `;
                slider.append(clients);
            });

            // Owl Carousel Reinitialize after appending data
            slider.owlCarousel({
                items: 1,
                loop: true,
                // nav: true,
                dots: true,
                center: true,
                autoplay: true,
                // navText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"]
            });
        }
    }
</script>
@endpush
