@extends('layouts.app')

@section('content')
	<div class="home_page__product-list css-5542cb">
		<div class="css-b59019">
			<div id="js-sort-bar" class="css-f2498e"></div>
			<div class="css-3fb406">
				<div class="css-81293a"> Sắp xếp theo </div>
				<div data-track-content="true" data-content-region-name="sortFilterProduct" data-content-name="sortProductResult" data-content-target="sort=discount&amp;order=DESC" class="css-16a7eb">
					<div class="css-81f8d9"> </div>
					<span class="css-e5afe4">Khuyến mãi tốt nhất</span>
				</div>
				<div data-track-content="true" data-content-region-name="sortFilterProduct" data-content-name="sortProductResult" data-content-target="sort=quantity.last_3_month&order=DESC" class="css-16a7eb">
					<div class="css-81f8d9"> </div>
					<span class="css-e5afe4">Bán chạy</span>
				</div>
				<div data-track-content="true" data-content-region-name="sortFilterProduct" data-content-name="sortProductResult" data-content-target="sort=new&order=DESC" class="css-16a7eb">
					<div class="css-81f8d9"> </div>
					<span class="css-e5afe4">Mới về</span>
				</div>
				<div data-track-content="true" data-content-region-name="sortFilterProduct" data-content-name="sortProductResult" data-content-target="sort=bestPrice&order=DESC" class="css-16a7eb">
					<div class="css-81f8d9"> </div>
					<span class="css-e5afe4">Giá giảm dần</span>
				</div>
				<div data-track-content="true" data-content-region-name="sortFilterProduct" data-content-name="sortProductResult" data-content-target="sort=bestPrice&order=ASC" class="css-16a7eb">
					<div class="css-81f8d9"> </div>
					<span class="css-e5afe4">Giá tăng dần</span>
				</div>
				<div class="css-5111ad">
					<div class="css-7044ff">
						<input type="text" maxlength="14" placeholder="Giá thấp nhất" class="css-f613cc" value="">
					</div>
					<span> 
						<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-minus" width="12" height="12" viewBox="0 0 24 24" stroke-width="2.5" stroke="#607D8B" fill="none" stroke-linecap="round" stroke-linejoin="round">
							<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
							<line x1="5" y1="12" x2="19" y2="12" />
						</svg>
					</span>
					<div class="css-7044ff">
						<input type="text" maxlength="14" placeholder="Giá cao nhất" class="css-f613cc" value="">
					</div>
					<button class="css-709319"></button>
				</div>
			</div>
		</div>
		<div class="hp__pl__container css-a46f11">
			@foreach ($listProducts as $prod)
				<a href="" class="css-2c7762">
					<div class="hp__pl__product product-card css-2e8efa d-flex flex-column align-content-center justify-content-center">
						<div class="product-card__content">
							<div class="pl__prod-image css-506c78">
								<picture>
									<img src="{{ $prod -> Image }}" alt="Flowers" class="css-963f94">
								</picture>
							</div>
							<div class="product-card__info">
								<div class="pl__prod-name css-fde874">
									{{ $prod -> Name }}
								</div>
								<div class="css-b38591">
									Chỉ còn 1 sản phẩm
								</div>
								<div class="css-e678cc">
									<div class="css-46c3ed">
										<div class="css-3c7ce6">
											<span class="css-690a6b">
												8.123.456
												<span class="css-9f611a">đ</span>
											</span>
											<div class="css-48812d">
												<span class="css-c5818a">
													1.234.567
													<span class="css-9f611a">đ</span>
												</span>
												<span class="css-027579"> 9% </span>
											</div>
										</div>
									</div>
									<div class="css-950c09">
										<div class="css-49039d">
											<img src="/icon/free-delivery.svg" alt="" style="width: 45px; height: 32px">
										</div>
									</div>
								</div>
								<div class="css-8280ac">
									<div class="css-41ab48"> QUÀ TẶNG </div>
									<div class="css-7bc7d3">
										<div class="css-83b632">
											<img data-src="" src="https://lh3.googleusercontent.com/joith777IiUPvSztaoEOH0UgTyRQiBTuV3IclRHWF0Uj8Y7bep8CxSCU4iYqAmetPCbZJ-JJqODsdgc9nw" class="css-904f61" alt="Khung mâm nghiêng - Từ 19” - 42″ M43N">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</a>
			@endforeach
		</div>
	</div>
@endsection
