<?php

namespace App\Http\Controllers;

use App\Product;
use App\Review;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'review' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        $review = new Review;
        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->user_id = auth()->user()->id;
        $product->reviews()->save($review);

        return response()->json([
            'message' => 'Review Added',
            'review'  => $review
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @param Review $review
     * @return JsonResponse
     */
    public function update(Request $request, Product $product, Review $review)
    {
        if (auth()->user()->id !== $review->user_id) {
            return response()->json([
                'message' => 'Action Forbidden'
            ]);
        }
        $request->validate([
            'review' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
        ]);

        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->save();

        return response()->json([
            'message' => 'Review Updated',
            'review'  => $review
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param Review $review
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Product $product, Review $review)
    {
        if (auth()->user()->id !== $review->user_id) {
            return response()->json([
                'message' => 'Action Forbidden'
            ]);
        }
        $review->delete();

        return response()->json(null, 204);
    }
}
