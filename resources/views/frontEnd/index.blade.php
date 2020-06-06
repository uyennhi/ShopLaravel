@extends('frontEnd.layouts.master')
@section('title','Home Page')
@section('sliceshow')
    <section>
        <!-- Slideshow container -->
                <div class="slideshow-container">

                <!-- Full-width images with number and caption text -->
                    <div class="mySlides fade">
                        <div class="numbertext" style="height:500px;">1 / 3</div>
                            <img src="{{asset('img/sliceshow5.jpg')}}" style="max-width:100%;max-height:50%;";>
                        <div class="text">Caption Text</div>
                    </div>

                    <div class="mySlides fade">
                        <div class="numbertext">2 / 3</div>
                            <img src="{{asset('img/sliceshow7.jpg')}}" style="width:100%">
                        <div class="text">Caption Two</div>
                    </div>

                    <div class="mySlides fade">
                        <div class="numbertext">3 / 3</div>
                            <img src="{{asset('img/sliceshow4.jpg')}}" style="width:100%">
                        <div class="text">Caption Three</div>
                    </div>

                <!-- Next and previous buttons -->
                <a class="prev" onclick="aplusSlides(-1)">&#10094;</a>
                <a class="next" onclick="aplusSlides(1)">&#10095;</a>
                </div>
                <br>

                <!-- The dots/circles -->
                <div style="text-align:center">
                <span class="dot" onclick="acurrentSlide(1)"></span>
                <span class="dot" onclick="acurrentSlide(2)"></span>
                <span class="dot" onclick="acurrentSlide(3)"></span>
                </div>
    </section>
@endsection
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    @include('frontEnd.layouts.category_menu')
                </div>

                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->
                        <h2 class="title text-center">Sản Phẩm</h2>
                        @foreach($products as $product)
                            @if($product->category->status==1)
                                <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <a href="{{url('/product-detail',$product->id)}}"><img src="{{url('products/small/',$product->image)}}" alt="" /></a>
                                        <h2>$ {{$product->price}}</h2>
                                        <p>{{$product->p_name}}</p>
                                        <a href="{{url('/product-detail',$product->id)}}" class="btn btn-default add-to-cart">View Product</a>
                                    </div>
                                </div>
                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">
                                        <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                        <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                            @endif
                        @endforeach
                    </div><!--features_items-->

                </div>
            </div>
        </div>
    </section>
@endsection