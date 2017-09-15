<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\AddressTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use App\Transformers\RelationTransformer;

class AddressController extends Controller
{
    public function checkAddress(Request $request)
    {
    	if (Address::where('_userid', '=', request()->userid)->count() > 0) {
    		
    		$address = Address::where('_userid', '=', request()->userid)->FirstOrFail();

    		return response()->json(['status' => true ,'address' => $address], 200);

    	} else {

	        return response()->json(['status' => false ,'address' => 'not found address user'], 500);

    	}
    }

    public function addaddress(Request $request)
    {
		$address = new Address;

        $address->_userid = $request->userid;
        $address->name = $request->address;
        $address->label = $request->label;
        $address->address = $request->street;
        $address->addressextra = $request->message;
        $address->latitude =  $request->latitude;
        $address->longitude =  $request->longitude;
        $address->isdeleted =  $request->isdeleted;
                    
        $address->save();

        return response()->json(['status' => true ,'address' => 'new address created'], 200);

    }

    public function index()
    {
        $paginator = Address::orderBy('id','asc')->paginate(request()->input('per_page'));
        $users = $paginator->getCollection();

        return fractal()->paginateWith(new IlluminatePaginatorAdapter($paginator))
                        ->collection($users, new AddressTransformer(), 'address')
                        ->serializeWith(new JsonApiSerializer(url('/api/')))
                        ->respond();
    }
}
