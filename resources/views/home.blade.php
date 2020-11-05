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
		<products-component :list_products='listProducts != null ? listProducts : @json($listProducts)'></products-component>
	</div>
	<div class="home_page__pagination">
		<pagination-component :gross_product="{!! $totalProd !!}" :total_pages="{!! $totalPages !!}" :default_page_numbs="defaultPageNumbs" @page_change_pagination="pageChangePagination($event)"></pagination-component>
	</div>
@endsection
