<!-- START SECTION SINGLE BANNER -->
<div class="section bg_light_blue2 pb-0 pt-md-0">
    <div class="container">
        <div class="row align-items-center flex-row-reverse">
            <div class="col-md-6 offset-md-1">
                <div class="medium_divider d-none d-md-block clearfix"></div>
                <div class="trand_banner_text text-center text-md-start">
                    <div class="heading_s1 mb-3">
                        <span class="sub_heading" id="singleBannerTitle"></span>
                        <h2 class="fs-2" id="singleBannerShortDes"></h2>
                    </div>
                    <h5 class="mb-4 fs-5" id="signleBannerDiscount"></h5>
                    <a href="{{url('/products-view')}}" class="btn btn-fill-out rounded-0">Shop Now</a>
                </div>
                <div class="medium_divider clearfix"></div>
            </div>
            <div class="col-md-5">
                <div class="text-center trading_img">
                    <img id="singleBannerImage" src="" alt="tranding_img" />
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION SINGLE BANNER -->
<script>
    async function singleBannerShow() {
        try {
            let res = await axios.get("/single-banner-view");
            let data = res.data.data; // access actual banner object
            document.getElementById('singleBannerTitle').innerHTML = data.title;
            document.getElementById('singleBannerShortDes').innerHTML = data.short_des;
            document.getElementById('signleBannerDiscount').innerHTML = data.discount;
            document.getElementById('singleBannerImage').src = data.image;
        } catch (error) {
            console.error("Error fetching banner:", error);
            document.getElementById('singleBannerTitle').innerHTML = "Failed to load banner.";
        }
    }
</script>


