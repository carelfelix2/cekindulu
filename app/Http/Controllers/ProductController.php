<?php
namespace App\Http\Controllers;use App\Models\Product;use App\Models\Category;use App\Models\Brand;use App\Models\Marketplace;use Illuminate\Http\Request;
class ProductController extends Controller
{
	public function index(Request $request)
	{
		$products = Product::published()
			->with(['category', 'brand', 'prices.marketplace'])
			->when($request->search, fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
			->when($request->category, fn($q) => $q->whereHas('category', fn($qq) => $qq->where('slug', $request->category)))
			->when($request->brand, fn($q) => $q->whereHas('brand', fn($qq) => $qq->where('slug', $request->brand)))
			->when($request->sort === 'price', fn($q) => $q->orderBy('lowest_price'))
			->when($request->sort === 'latest', fn($q) => $q->latest())
			->when(!$request->sort || $request->sort === 'worth', fn($q) => $q->orderByDesc('worth_it_score'))
			->paginate(12)
			->withQueryString();

		return view('pages.products.index', [
			'products' => $products,
			'categories' => Category::where('is_active', 1)->get(),
			'brands' => Brand::orderBy('name')->get(),
			'marketplaces' => Marketplace::where('is_active', 1)->get(),
		]);
	}

	public function show(Product $product)
	{
		abort_unless($product->status === 'published', 404);
		$product->load(['category', 'brand', 'images', 'prices.marketplace', 'prices.affiliateLinks']);
		$alternatives = Product::published()
			->where('id', '!=', $product->id)
			->where('category_id', $product->category_id)
			->with(['category', 'brand', 'prices.marketplace'])
			->orderByDesc('worth_it_score')
			->limit(4)
			->get();

		return view('pages.products.show', compact('product', 'alternatives'));
	}

	/**
	 * Simple JSON search endpoint used by the compare page.
	 */
	public function search(Request $request)
	{
		$q = trim($request->get('q', ''));
		if (strlen($q) < 2) {
			return response()->json([]);
		}

		$products = Product::published()
			->where('name', 'like', "%{$q}%")
			->limit(10)
			->get(['id', 'name', 'thumbnail', 'lowest_price', 'worth_it_score']);

		return response()->json($products);
	}
}
