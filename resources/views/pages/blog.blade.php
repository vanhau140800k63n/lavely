@extends('master')
@section('meta')
    <meta name="description" content="CỬA HÀNG DEVSNE.VN - Mang đến cho bạn kiến thức về sự kết hợp của sneakers và quần áo tạo nên sức hút của cá nhân bạn">
    <meta name="keywords" content="DEVSNE, devsne, devsnevn, quần áo devsne, giày devsne, DEVSNE.VN, giày giá rẻ, blog">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="bingbot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <link rel="canonical" href="https://devsne.vn/blog">
    <meta property="og:locale" content="vi_VN">
    <meta property="og:type" content="website">
    <meta property="og:title" content="BLOG | SNEAKER SHOP">
    <meta property="og:description" content="CỬA HÀNG DEVSNE.VN - Mang đến cho bạn kiến thức về sự kết hợp của sneakers và quần áo tạo nên sức hút của cá nhân bạn">
    <meta property="og:url" content="https://devsne.vn/blog">
    <meta property="og:site_name" content="DEVSNE.VN">
    <meta property="article:publisher" content="https://www.facebook.com/ctvdevsneaker">
    <title>BLOG | SNEAKER SHOP</title>
@endsection
@section('content')
<!-- Hero Section Begin -->
<section class="hero hero-normal">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span>DANH MỤC</span>
                    </div>
                    <ul>
                        <li style="font-weight: bold"><a href="./sneakers">SNEAKERS (60)</a></li>
                        <li style="padding-left: 30px"><a href="./sneakers/Vans">VANS (15)</a></li>
                        <li style="padding-left: 30px"><a href="./sneakers/NIKE">NIKE  (12)</a></li>
                        <li style="padding-left: 30px"><a href="./sneakers/Converse">CONVERSE (7)</a></li>
                        <li style="padding-left: 30px"><a href="./sneakers/ADIDAS">ADIDAS (8)</a></li>
                        <li style="padding-left: 30px"><a href="./sneakers/MLB">MLB (16)</a></li>
                        <li style="padding-left: 30px"><a>KHÁC (22)</a></li>
                        <li style="font-weight: bold"><a href="./sneakers/Clothers">CLOTHERS</a></li>
                        <li style="font-weight: bold"><a href="./sneakers/Balo">BALOS</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="hero__search">
                    <div class="hero__search__form">
                        <form>
                            <div class="hero__search__categories">
                                All Categories
                                <span class="arrow_carrot-down"></span>
                            </div>
                            <input type="text" placeholder="Bạn muốn tìm kiếm">
                            <button type="submit" class="site-btn">SEARCH</button>
                        </form>
                    </div>
                    <div class="hero__search__phone">
                        <div class="hero__search__phone__icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <div class="hero__search__phone__text">
                            <h5>0988251527</h5>
                            <span>Hỗ trợ 24/7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Blog Section Begin -->
<section class="blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="blog__sidebar">
                    <div class="blog__sidebar__search">
                        <form>
                            <input type="text" placeholder="Search...">
                            <button type="submit"><span class="icon_search"></span></button>
                        </form>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Danh mục</h4>
                        <ul>
                            <li><a>Tất cả</a></li>
                            <li><a>Sneakers (20)</a></li>
                            <li><a>Clothers (5)</a></li>
                            <li><a>Balo (9)</a></li>
                        </ul>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Bài viết mới</h4>
                        <div class="blog__sidebar__recent">
                            <a class="blog__sidebar__recent__item">
                                <div class="blog__sidebar__recent__item__pic">
                                    <img src="source/img/blog/blog1.jpg" alt="">
                                </div>
                                <div class="blog__sidebar__recent__item__text">
                                    <h6>09 Kinds Of Vegetables<br /> Protect The Liver</h6>
                                    <span>SEPT 09, 2019</span>
                                </div>
                            </a>
                            <a class="blog__sidebar__recent__item">
                                <div class="blog__sidebar__recent__item__pic">
                                    <img src="source/img/blog/blog2.jpg" alt="">
                                </div>
                                <div class="blog__sidebar__recent__item__text">
                                    <h6>Tips You To Balance<br /> Nutrition Meal Day</h6>
                                    <span>JUNE 12, 2019</span>
                                </div>
                            </a>
                            <a class="blog__sidebar__recent__item">
                                <div class="blog__sidebar__recent__item__pic">
                                    <img src="source/img/blog/blog3.jpg" alt="">
                                </div>
                                <div class="blog__sidebar__recent__item__text">
                                    <h6>4 Principles Help You Lose <br />Weight With Vegetables</h6>
                                    <span>AUGUST 14, 2019</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Search By</h4>
                        <div class="blog__sidebar__item__tags">
                            <a>Vans</a>
                            <a>Converse</a>
                            <a>NIKE</a>
                            <a>ADIDAS</a>
                            <a>MLB</a>
                            <a>BALENS</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="source/img/blog/blog1.jpg" alt="">
                            </div>
                            <div class="blog__item__text">
                                <ul>
                                    <li><i class="fa fa-calendar-o"></i> AUGUST 14,2020</li>
                                    <li><i class="fa fa-comment-o"></i> 7</li>
                                </ul>
                                <h5><a>NHỮNG MẪU GIÀY SNEAKER CỰC “BEAT” CHO TỦ GIÀY CỦA BẠN</a></h5>
                                <p>Beater là một phần không thể thiếu trong tủ giày của sneakerhead, là những mẫu ...</p>
                                <a class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="source/img/blog/blog2.jpg" alt="">
                            </div>
                            <div class="blog__item__text">
                                <ul>
                                    <li><i class="fa fa-calendar-o"></i> Sept 1,2020</li>
                                    <li><i class="fa fa-comment-o"></i> 5</li>
                                </ul>
                                <h5><a>Hướng dẫn 6 bước Vệ sinh giày Sneaker tại nhà đơn giản</a></h5>
                                <p>Để đảm bảo hiệu suất cao nhất của đôi giày của bạn theo thời gian, bạn nên chăm sóc và bảo dưỡng đúng cách, bao gồm cả việc vệ sinh. Bạn có thể giữ cho các đôi giày sneaker của bạn như mới với một vài bước cực kì dễ dàng ...</p>
                                <a class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="source/img/blog/blog3.jpg" alt="">
                            </div>
                            <div class="blog__item__text">
                                <ul>
                                    <li><i class="fa fa-calendar-o"></i> AUGUST 17,2019</li>
                                    <li><i class="fa fa-comment-o"></i> 5</li>
                                </ul>
                                <h5><a>5 CÁCH PHỐI GIÀY VỚI QUẦN ỐNG RỘNG</a></h5>
                                <p>Những chiếc quần ống rộng với nhiều thiết kế đa dạng nên cách phối giày với chúng cũng đa dạng không kém...</p>
                                <a class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="source/img/blog/blog4.jpg" alt="">
                            </div>
                            <div class="blog__item__text">
                                <ul>
                                    <li><i class="fa fa-calendar-o"></i> DEC 15,2019</li>
                                    <li><i class="fa fa-comment-o"></i> 5</li>
                                </ul>
                                <h5><a>Top 12 mẫu giày thể thao đẹp</a></h5>
                                <p>Chunky sneaker là thiết kế gây ấn tượng mạnh mẽ đối với các tín đồ sneaker năm 2018. Chunky sneaker hiểu đơn giản là những dòng giày kích thước to, bộ đế dày ...</p>
                                <a class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="source/img/blog/blog5.jpg" alt="">
                            </div>
                            <div class="blog__item__text">
                                <ul>
                                    <li><i class="fa fa-calendar-o"></i> SEPT 5,2019</li>
                                    <li><i class="fa fa-comment-o"></i> 5</li>
                                </ul>
                                <h5><a>Cách nhận biết giày Balenciaga Rep thường và F1</a></h5>
                                <p>F1 là viết tắt của Fake1, chất lượng kém hơn hàng fake, chỉ dùng được khoảng vài tháng, Form giày ôm sát chân, gây khó chịu, không thoáng khí, làm cho người mang cảm thấy vướng ... </p>
                                <a class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic">
                                <img src="source/img/blog/blog6.jpg" alt="">
                            </div>
                            <div class="blog__item__text">
                                <ul>
                                    <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                    <li><i class="fa fa-comment-o"></i> 5</li>
                                </ul>
                                <h5><a>Những đôi giày sneaker nên có trong tủ đồ</a></h5>
                                <p>Sức hút của những đôi giày sneaker đã vượt lên trên tầng cao của rất nhiều những loại giày bình thường khác. Tuy với đặc tính chung nhưng những đôi giày sneaker lại mang những thiết kế phá cách và đầy sáng tạo...</p>
                                <a class="blog__btn">READ MORE <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->
@endsection