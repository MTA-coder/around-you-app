<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateImageItemRequest;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\GetfilterItemsRequest;
use App\Http\Requests\GetSearchItemsRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\DeleteProductRequest;
use App\Http\Requests\GetUserItemrequest;
use App\Http\Requests\CreateViewRequest;
use App\Http\Requests\GetProductRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Image;
use App\Models\User;
use App\Models\View;

class ProductController extends Controller
{
    private $product, $user;

    public function __construct(Product $product, User $user)
    {
        $this->product = $product;
        $this->user = $user;
    }

    public function get(GetProductRequest $request)
    {
        $data = $request->validated();
        $products = $this->product->where('subCategory_id', $data['subCategory_id'])->whereNull('deleted_at')->with(['images', 'user', 'views'])->get();

        $arrayProducts = collect($products)->each(function ($item) {
            $item['view'] = $item->views()->count();
            unset($item['views']);
        });


        return response()->json(['status' => 'OK', 'data' => $arrayProducts], 200);
    }

    public function getAuth(GetProductRequest $request)
    {
        $data = $request->validated();
        $products = $this->product->where('subCategory_id', $data['subCategory_id'])->whereNull('deleted_at')->with(['images', 'user', 'views', 'favourites'])->get();

        $arrayProducts = collect($products)->each(function ($item) {
            $item['isFavourite'] = false;
            $item['view'] = $item->views()->count();
            collect($item->favourites)->each(function ($fav) use ($item) {
                if ($fav['user_id'] == Auth::id())
                    $item['isFavourite'] = true;
            });
            unset($item['views']);
            unset($item['favourites']);
        });

        return response()->json(['status' => 'OK', 'data' => $arrayProducts], 200);
    }

    public function create(CreateProductRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = Auth::id();
        $product = $this->product->create($data);

        if ($product == null) {
            return response()->json(['status' => 'ERROR', 'msg' => 'Operation Fail'], 510);
        }
        return response()->json(['status' => 'OK', 'data' => $product], 220);
    }

    public function createView(CreateViewRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $view = (new View())->where('user_id', $data['user_id'])->where('product_id', $data['product_id'])->get();
        if (collect($view)->isEmpty())
            $view = (new View())->create($data);

        if ($view == null) {
            return response()->json(['status' => 'ERROR', 'msg' => 'Operation Fail'], 510);
        }
        return response()->json(['status' => 'OK', 'data' => $view], 220);
    }

    public function edit(UpdateProductRequest $request, $productId)
    {
        $data = $request->validated();
        unset($data['product_id']);
        $product = $this->product->where('id', $productId)->update($data);

        if ($product == null) {
            return response()->json(['status' => 'ERROR', 'msg' => 'Operation Fail'], 510);
        }
        return response()->json(['status' => 'OK', 'data' => $product], 230);
    }

    public function delete(DeleteProductRequest $request, $productId)
    {
        $data = $request->validated();
        unset($data['product_id']);

        $product = $this->product->find(['id' => $productId])->first();
        if (Auth::id() == $product->user_id || Auth::user()->is_Admin)
            $product->delete();
        else
            return response()->json(['status' => 'OK', 'data' => 'Not Authenticated'], 444);

        return response()->json(['status' => 'OK', 'data' => 'Data has been Deleted'], 240);
    }

    public function getItem(GetUserItemrequest $request, $userId)
    {
        $data = $request->validated();
        $user = $this->user->where('id', $userId)->with(['products.images', 'products.views'])->get();

        $users = collect($user)->each(function ($item) {
            collect($item->products)->each(function ($item) {
                $item['view'] = $item->views()->count();
                unset($item['views']);
            });
        });

        return response()->json(['status' => 'OK', 'data' => $users], 210);
    }

    public function imageCreate(CreateImageItemRequest $request)
    {
        $data = $request->validated();

        $image = (new Image())->create($data);

        return response()->json(['status' => 'OK', 'data' => $image], 210);
    }

    public function searchItems(GetSearchItemsRequest $request)
    {
        $data = $request->validated();
        $products = $this->product
            ->where('name', 'like', '%' . $data['name'] . '%')
            ->orWhere('description', 'like', '%' . $data['name'] . '%')
            ->with(['images', 'user', 'views', 'favourites'])->get();

        $arrayProducts = collect($products)->each(function ($item) {
            $item['isFavourite'] = false;
            $item['view'] = $item->views()->count();
            collect($item->favourites)->each(function ($fav) use ($item) {
                if ($fav['user_id'] == Auth::id())
                    $item['isFavourite'] = true;
            });
            unset($item['views']);
            unset($item['favourites']);
        });

        return response()->json(['status' => 'OK', 'data' => $arrayProducts], 200);
    }

    public function searchItemsNoAuth(GetSearchItemsRequest $request)
    {
        $data = $request->validated();
        $products = $this->product
            ->where('name', 'like', '%' . $data['name'] . '%')
            ->orWhere('description', 'like', '%' . $data['name'] . '%')
            ->with(['images', 'user', 'views'])
            ->get();

        $arrayProducts = collect($products)->each(function ($item) {
            $item['view'] = $item->views()->count();
            unset($item['views']);
        });

        return response()->json(['status' => 'OK', 'data' => $arrayProducts], 200);
    }


    public function filter(GetfilterItemsRequest $request)
    {
        $data = $request->validated();
        $lowPrice = $request->get('lowPrice');
        $highPrice = $request->get('highPrice');
        $order = $request->get('order');
        $city = $request->get('city');
        $isNew = $request->get('isNew');
       $subCategory = $request->get('subCategory_id');
        $products =
            $this->product
               ->when($subCategory, function ($query, $subCategory) {
                    return $query->where('subCategory_id', $subCategory);
                })
                ->when($lowPrice, function ($query, $lowPrice) {
                    return $query->where('price', '>=', $lowPrice);
                })
                ->when($highPrice, function ($query, $highPrice) {
                    return $query->where('price', '<=', $highPrice);
                })
                ->when($isNew, function ($query, $isNew) {
                    return $query->where('isNew', $isNew == "true" ? 1 : 0);
                })
                ->when($city, function ($query, $city) {
                    return $query->where('city', $city);
                })
                ->when($order, function ($query, $order) {
                    return $query->orderBy('created_at', $order);
                })
                ->with(['images', 'user', 'views', 'favourites'])
                ->get();

        $arrayProducts = collect($products)->each(function ($item) {
            $item['isFavourite'] = false;
            $item['view'] = $item->views()->count();
            collect($item->favourites)->each(function ($fav) use ($item) {
                if ($fav['user_id'] == Auth::id())
                    $item['isFavourite'] = true;
            });
            unset($item['views']);
            unset($item['favourites']);
        });

        return response()->json(['status' => 'OK', 'data' => $arrayProducts], 200);
    }
}
