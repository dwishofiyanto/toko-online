
@foreach($produk['data'] as $produk)
								
                                <div class="col">
                                    <div class="card rounded-0 product-card">
                                        <div class="card-header bg-transparent border-bottom-0">
                                            <div class="d-flex align-items-center justify-content-end gap-3">
                                                <a  >
                                                    <div class="product-compare"><span><i class="bx bx-git-compare"></i> Compare</span>
                                                    </div>
                                                </a>
                                                <a href="javascript:;">
                                                    <div class="product-wishlist"> <i class="bx bx-heart"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <img src="assets/images/products/01.png" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <div class="product-info">
                                                <a href="javascript:;">
                                                    <p class="product-catergory font-13 mb-1">{{$kategori->nama_kategori}}</p>
                                                </a>
                                                <a href="javascript:;">
                                                    <h6 class="product-name mb-2">{{$produk['nama_barang']}}</h6>
                                                </a>
                                                <div class="d-flex align-items-center">
                                                    <div class="mb-1 product-price">	
                                                        <!--<span class="me-1 text-decoration-line-through">$99.00</span>-->
                                                        <span class="text-white fs-5">Rp. {{number_format($produk['harga'])}}</span>
                                                    </div>
                                                    <div class="cursor-pointer ms-auto">	<i class="bx bxs-star text-white"></i>
                                                        <i class="bx bxs-star text-white"></i>
                                                        <i class="bx bxs-star text-light-4"></i>
                                                        <i class="bx bxs-star text-light-4"></i>
                                                        <i class="bx bxs-star text-light-4"></i>
                                                    </div>
                                                </div>
                                                <div class="product-action mt-2">
                                                    <div class="d-grid gap-2">
                                                        <a href="javascript:;" class="btn btn-light btn-ecomm">	<i class="bx bxs-cart-add"></i>Add to Cart</a>	<a href="javascript:;" class="btn btn-link btn-ecomm" data-bs-toggle="modal" data-bs-target="#QuickViewProduct{{$produk['id']}}"><i class="bx bx-zoom-in"></i>Quick View</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



<!-- Modal -->
<div class="modal fade" id="QuickViewProduct{{$produk['id']}}">
<div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-xl-down">
    <div class="modal-content bg-dark-4 rounded-0 border-0">
        <div class="modal-body">
            <button type="button" class="btn-close float-end" data-bs-dismiss="modal"></button>
            <div class="row g-0">
                <div class="col-12 col-lg-6">
                    <div class="image-zoom-section">
                        <div class="product-gallery owl-carousel owl-theme border mb-3 p-3" data-slider-id="1">
                            <div class="item">
                                <img src="{{ asset('assets/images/product-gallery/01.png') }}" class="img-fluid" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('assets/images/product-gallery/02.png') }}" class="img-fluid" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('assets/images/product-gallery/03.png') }}" class="img-fluid" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('assets/images/product-gallery/04.png') }}" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="owl-thumbs d-flex justify-content-center" data-slider-id="1">
                            <button class="owl-thumb-item">
                                <img src="{{ asset('assets/images/product-gallery/01.png') }}" class="" alt="">
                            </button>
                            <button class="owl-thumb-item">
                                <img src="{{ asset('assets/images/product-gallery/02.png') }}" class="" alt="">
                            </button>
                            <button class="owl-thumb-item">
                                <img src="{{ asset('assets/images/product-gallery/03.png') }}" class="" alt="">
                            </button>
                            <button class="owl-thumb-item">
                                <img src="{{ asset('assets/images/product-gallery/04.png') }}" class="" alt="">
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="product-info-section p-3">
                        <h3 class="mt-3 mt-lg-0 mb-0">{{$produk['nama_barang']}}</h3>
                        <div class="product-rating d-flex align-items-center mt-2">
                            <div class="rates cursor-pointer font-13">	<i class="bx bxs-star text-warning"></i>
                                <i class="bx bxs-star text-warning"></i>
                                <i class="bx bxs-star text-warning"></i>
                                <i class="bx bxs-star text-warning"></i>
                                <i class="bx bxs-star text-light-4"></i>
                            </div>
                            <div class="ms-1">
                                <p class="mb-0">(24 Ratings)</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mt-3 gap-2">
                            <!--<h5 class="mb-0 text-decoration-line-through text-light-3">$98.00</h5>-->
                            <h4 class="mb-0">Rp. {{number_format($produk['harga'])}}</h4>
                        </div>
                        <div class="mt-3">
                            <h6>Discription :</h6>
                            <p class="mb-0">{{$produk['deskripsi']}}</p>
                        </div>
                        <dl class="row mt-3">	<dt class="col-sm-3">Product id</dt>
                            <dd class="col-sm-9">#BHU5879</dd>	<dt class="col-sm-3">Delivery</dt>
                            <dd class="col-sm-9">Russia, USA, and Europe</dd>
                        </dl>
                        <div class="row row-cols-auto align-items-center mt-3">
                            <div class="col">
                                <label class="form-label">Quantity</label>
                                <select class="form-select form-select-sm">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Size</label>
                                <select class="form-select form-select-sm">
                                    <option>S</option>
                                    <option>M</option>
                                    <option>L</option>
                                    <option>XS</option>
                                    <option>XL</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Colors</label>
                                <div class="color-indigators d-flex align-items-center gap-2">
                                    <div class="color-indigator-item bg-primary"></div>
                                    <div class="color-indigator-item bg-danger"></div>
                                    <div class="color-indigator-item bg-success"></div>
                                    <div class="color-indigator-item bg-warning"></div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                        <div class="d-flex gap-2 mt-3">
                            <a href="javascript:;" class="btn btn-white btn-ecomm">	<i class="bx bxs-cart-add"></i>Add to Cart</a>	<a href="javascript:;" class="btn btn-light btn-ecomm"><i class="bx bx-heart"></i>Add to Wishlist</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</div>
</div>
<!--end quick view product-->





                        @endforeach