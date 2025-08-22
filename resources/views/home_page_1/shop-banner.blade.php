<!-- START SECTION BANNER -->
<div class="section pb_20">
	<div class="container">
    	<div class="row" id="shopBannerSection">
        	
            
        </div>
    </div>
</div>
<!-- END SECTION BANNER -->

<script>
    async function ShopBanner() {
        let res = await axios.get("/shop-banner-view");
        $("#shopBannerSection").empty();
        res.data['data'].forEach((item,i)=>{
            
            let shopBanner=`<div class="col-md-6">
            	<div class="single_banner">
                	<img src="${item['image']}" alt="shop_banner_img1"/>
                    <div class="single_banner_info">
                        <h5 class="single_bn_title1">${item['title']}</h5>
                        <h3 class="single_bn_title">${item['short_des']}</h3>
                        <a href="#" class="single_bn_link">Shop Now</a>
                    </div>
                </div>
            </div>`
            $("#shopBannerSection").append(shopBanner)
        })
    }
</script>