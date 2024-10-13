<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ProductController extends Controller
    {
        public function allProducts()
        {
            $products = Product::with('category')->get();

            if ($products->isEmpty()) {
                return Response::json([
                    'message' => 'No products found.',
                ], 404);
            }
            return ProductResource::collection($products);
        }

        public function create(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                "price"=>"required|numeric",
            ]);

            if ($validator->fails()) {
                return Response::json([
                    'errors' => $validator->errors(),
                    'status_code' => 422,
                ], 422);
            }

            try {
                $user = JWTAuth::user();

                $product = Product::create([
                    'category_id' => $request->category_id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'price'=>$request->price,
                ]);



                $product->load('category');

                return Response::json([
                    'message' => 'Post created successfully.',
                    'data' => $product,
                    'status_code' => 201,
                ], 201);
            }

            catch (\Tymon\JWTAuth\Exceptions\JWTException $exception) {
                return Response::json([
                    'message' => 'Invalid access token or user not found.',
                    'status_code' => 401,
                ], 401);
            } catch (Throwable $exception) {
                return Response::json([
                    'message' => 'An error occurred while creating a post.',
                    'error' => $exception->getMessage(),
                ], 500);
            }
        }
        public function show($id)
        {
            try {
                $product = Product::with('category')->find($id);

                if (!$product) {
                    return Response::json([
                        'message' => 'Product not found.',
                    ], 404);
                }

                return new ProductResource($product);

            } catch (Throwable $exception) {
                return Response::json([
                    'message' => 'An error occurred while fetching the product.',
                    'error' => $exception->getMessage(),
                ], 500);
            }
        }
        public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'category_id' => 'nullable|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                "price"=>"required|numeric",

            ]);

            if ($validator->fails()) {
                return Response::json([
                    'errors' => $validator->errors(),
                    'status_code' => 422,
                ], 422);
            }

            $product =Product::find($id);

            if (!$product) {
                return Response::json([
                    'message' => 'Unauthorized or product not found.',
                    'status_code' => 403,
                ], 403);
            }

            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'description' => $request->description,
                'price'=>$request->price,
            ]);

            $product->load('category');

            return Response::json([
                'message' => 'Product updated successfully.',
                'data' => $product,
                'status_code' => 200,
            ], 200);
        } catch (JWTException $exception) {
            return Response::json([
                'message' => 'Invalid access token or user not found.',
                'status_code' => 401,
            ], 401);
        } catch (Throwable $exception) {
            return Response::json([
                'message' => 'An error occurred while updating the product.',
                'error' => $exception->getMessage(),
            ], 500);
        }
    }
        public function delete( $id)
        {
            try {
                $product = Product::find($id);

                if (!$product) {
                    return Response::json([
                        'message' => 'Unauthorized or product not found.',
                        'status_code' => 403,
                    ], 403);
                }

                

                $product->delete();

                return Response::json([
                    'message' => 'Product deleted successfully.',
                    'status_code' => 200,
                ], 200);
            } catch (JWTException $exception) {
                return Response::json([
                    'message' => 'Invalid access token or user not found.',
                    'status_code' => 401,
                ], 401);
            } catch (Throwable $exception) {
                return Response::json([
                    'message' => 'An error occurred while deleting the product.',
                    'error' => $exception->getMessage(),
                ], 500);
            }
        }
    }

