<section class="related-movies">
    <div id="halim_related_movies-2xx" class="wrap-slider">
      <div class="xuongdong"></div>
      <span class="label-content-truyen">Có thể bạn muốn xem<i class='bx bxs-chevron-right'></i></span>
      <div class="xuongdong"></div>
       <div id="halim_related_movies-2" class="owl-carousel owl-theme related-film">

         @foreach ($truyenlienquan as $truyenlienquans)
          <article class="thumb grid-item post-38498">
             <div class="halim-item">
                <a class="halim-thumb" href="{{url('/truyen-tranh/'.$truyenlienquans->duongdantruyen)}}" title="{{$truyenlienquans->tentruyen}}">
                   <figure><img style="height: 200px; min-height: 200px; border: 1px solid #ccc;" class="lazy img-responsive" src="{{asset('uploads/truyen/'.$truyenlienquans->hinhnen)}}" alt="{{$truyenlienquans->tentruyen}}" title="{{$truyenlienquans->tentruyen}}"></figure> 
                   {{-- <div class="icon_overlay"></div> --}}
                   <div class="halim-post-title-box">
                      <div class="halim-post-title ">
                         <p class="entry-title">{{$truyenlienquans->tentruyen}}</p>
                         <p class="original_title">{{$truyenlienquans->tentienganh}}</p>
                      </div>
                   </div>
                </a>
             </div>
          </article>
          @endforeach
            
       </div>
       <script>
          jQuery(document).ready(function($) {				
          var owl = $('#halim_related_movies-2');
          owl.owlCarousel({loop: true,margin: 8,autoplay: true,autoplayTimeout: 4000,autoplayHoverPause: true,nav: true,navText: ['<i class="bx bxs-chevron-left"></i>', '<i class="bx bxs-chevron-right"></i>'],responsiveClass: true,responsive: {0: {items:2},480: {items:3}, 600: {items:4},1000: {items: 4}}})});
       </script>
    </div>
 </section>