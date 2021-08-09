<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateFavouriteRequest;
use App\Models\Favourite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class FavouriteController extends Controller
{
    public function create(CreateFavouriteRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = Auth::id();
        $data['product_id'] = (int)$data['product_id'];
        $favourite = (new Favourite())->where('user_id', $data['user_id'])->where('product_id', $data['product_id'])->get();
        if (collect($favourite)->isEmpty()) {
            $favourite = (new Favourite())->create($data);
        } else {
            $favourite = (new Favourite())->where('user_id', $data['user_id'])->where('product_id', $data['product_id']);
            $favourite->delete();
        }

        if ($favourite == null) {
            return response()->json(['status' => 'ERROR', 'msg' => 'Operation Fail'], 510);
        }
        return response()->json(['status' => 'OK', 'data' => $favourite], 220);

    }

    public function get(Request $request)
    {
        $favourite = (new Favourite())->where('user_id', Auth::id())->with(['product', 'user', 'product.views', 'product.images'])->get();

        $favourites = collect($favourite)->each(function ($item) {
            if ($item->product != null) {
                $item->product['view'] = $item->product['views']->count();
                unset($item->product['views']);
            }
        });

        return response()->json(['status' => 'OK', 'data' => $favourites], 200);
    }

}
