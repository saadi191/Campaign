<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\Api\ModelNotFoundException;
use App\Http\Controllers\Admin\Api\ParticipantFiles;
use App\Http\Controllers\Admin\Api\Temporary;
use App\Http\Controllers\Admin\Api\Winners;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

use App;
use Hash;

use App\Models\Attempts;
use App\Models\Campaign;
use App\Models\Cities;
use App\Models\Gifts;
use App\Models\GiftsAllocation;
use App\Models\Leaflets;
use App\Models\LeafletsRange;
use App\Models\Locations;
use App\Models\Participant;
use App\Models\Voucher;
use App\Models\VoucherCodes;
use App\Models\Helpdesk;
use App\Models\LeafletsModeration;
use App\Models\LeafletsUpload;

use Intervention\Image\ImageManager;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

use Session;
use Carbon\Carbon;

use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendNotification;


class AdminController extends Controller
{
    /**
     * Constructor
     */
//    public function __construct() {
//        $this->middleware('auth:admin_api');
//    }

    public function allParticipants(Request $request){
      $model = new Leaflets();
      if($request['search']){
      	$participants = $model::with(['gift','voucher','voucher.voucher','location','participant','participant.getCity','upload'])
        ->orWhereHas('location', function ($query) use($request){
          $query->where('name','LIKE','%'.$request['search'].'%');
        })
        ->orWhereHas('location', function ($query) use($request){
          $query->where('description','=',$request['search']);
        })
        ->orWhereHas('participant', function ($query) use($request){
          $mobile = preg_replace('/^(009665|9665|\+9665|05|5)/', '9665', $request['search']);
          $query->where('mobile','LIKE','%'.$mobile.'%');
      	})

        ->orWhere('code','LIKE','%'.$request['search'].'%')
        ->orWhere('serial','LIKE','%'.$request['search'].'%')
        ->whereNull('deleted_at')
      	->orderBy('updated_at', 'ASC')->paginate(16);

        $response = [
          'pagination' => [
              'total' => $participants->total(),
              'per_page' => $participants->perPage(),
              'current_page' => $participants->currentPage(),
              'last_page' => $participants->lastPage(),
              'from' => $participants->firstItem(),
              'to' => $participants->lastItem()
          ],
            'data' => $participants->toArray(),
        ];
      } else {
        $participants = $model::with(['location','participant','participant.getCity','upload','gift','voucher','voucher.voucher'])
        ->orWhereHas('participant',function($q){
            $q->whereNotNull('mobile');
        })
        ->whereNull('deleted_at')
      	->orderBy('updated_at', 'ASC')->paginate(16);

        $response = [
          'pagination' => [
              'total' => $participants->total(),
              'per_page' => $participants->perPage(),
              'current_page' => $participants->currentPage(),
              'last_page' => $participants->lastPage(),
              'from' => $participants->firstItem(),
              'to' => $participants->lastItem()
          ],
            'data' => $participants->toArray(),
        ];
      }
      return response()->json($response);
    }

    public function pendingModeration(Request $request) {
      $model = new LeafletsModeration();
    		if($request['search']){
    			$participants = $model::with(['leaflet','leaflet.participant' ,'leaflet.participant.city','leaflet.voucher','upload','leaflet.leafletsTrashed'])
          ->whereHas('leaflet.participant', function ($query) use($request){
            $mobile = preg_replace('/^(009665|9665|\+9665|05|5)/', '9665', $request['search']);
    			  $query->where('mobile','LIKE','%'.$mobile.'%');
    			})
          ->where('uploaded', 1)
          ->where('approved', '0', 0)
          ->whereNull('deleted_at')
      		->orderBy('updated_at', 'ASC')->paginate(16);

          $response = [
            'pagination' => [
                'total' => $participants->total(),
                'per_page' => $participants->perPage(),
                'current_page' => $participants->currentPage(),
                'last_page' => $participants->lastPage(),
                'from' => $participants->firstItem(),
                'to' => $participants->lastItem()
            ],
              'data' => $participants->toArray(),
          ];
      } else {
          $participants = $model::with(['leaflet','leaflet.participant','leaflet.participant.city','leaflet.voucher','upload','leaflet.leafletsTrashed'])
          ->where('uploaded', 1)
          ->where('approved', '0', 0)
          ->whereNull('deleted_at')
      		->orderBy('updated_at', 'ASC')->paginate(16);

          $response = [
            'pagination' => [
                'total' => $participants->total(),
                'per_page' => $participants->perPage(),
                'current_page' => $participants->currentPage(),
                'last_page' => $participants->lastPage(),
                'from' => $participants->firstItem(),
                'to' => $participants->lastItem()
            ],
              'data' => $participants->toArray(),
          ];
      }
      return response()->json($response);
    }

    public function pendingHelp(Request $request){
      $model = new HelpDesk();
      if($request['search']){
      	$participants = $model::with(['leaflet','leaflet.participant','leaflet.participant.city','participant','participant.city'])
        ->whereHas('participant', function ($query) use($request){
          $mobile = preg_replace('/^(009665|9665|\+9665|05|5)/', '9665', $request['search']);
          $query->where('mobile','LIKE','%'.$mobile.'%');
      	})
        ->whereNull('deleted_at')
        ->where('approved', 0)
        ->where('rejected_by', 0)
      	->orderBy('updated_at', 'ASC')->paginate(16);

        $response = [
          'pagination' => [
              'total' => $participants->total(),
              'per_page' => $participants->perPage(),
              'current_page' => $participants->currentPage(),
              'last_page' => $participants->lastPage(),
              'from' => $participants->firstItem(),
              'to' => $participants->lastItem()
          ],
            'data' => $participants->toArray(),
        ];
      } else {
      $participants = $model::with(['leaflet','leaflet.participant','leaflet.participant.city','participant','participant.city'])
        ->whereNull('deleted_at')
        ->where('approved', 0)
        ->where('rejected_by', 0)
      	->orderBy('updated_at', 'ASC')->paginate(16);

//      dd($participants);

        $response = [
          'pagination' => [
              'total' => $participants->total(),
              'per_page' => $participants->perPage(),
              'current_page' => $participants->currentPage(),
              'last_page' => $participants->lastPage(),
              'from' => $participants->firstItem(),
              'to' => $participants->lastItem()
          ],
            'data' => $participants->toArray(),
        ];
      }
      return response()->json($response);
    }


    public function acceptHelp(Request $request) {
      $user = auth()->user();

      $leaflet = HelpDesk::with(['leaflet','participant'])
      ->where('id', $request->id)->first();
      Leaflets::where('code', $leaflet->code)->delete();

      HelpDesk::where('id', $request->id)->update(['approved' => '1', 'approved_by' => $user->id]);

      try {
        $client = new Client();

        if($leaflet['participant']['locale'] === 'en'){
          $response = $client->request('POST', 'http://api.unifonic.com/rest/Messages/Send', [
              'form_params' => [
                'AppSid' => 'UGp8wc83W3GzrSmORNwo9EOVg1ijNv',
                'Recipient' => $leaflet['participant']['mobile'],
                'Body' => 'Dear '. $leaflet['participant']['fullname'].', Your code '.$leaflet->code.' can now be used on the website',
              ]
          ]);
        }
        if($leaflet['participant']['locale'] === 'ar'){
          $response = $client->request('POST', 'http://api.unifonic.com/rest/Messages/Send', [
              'form_params' => [
                'AppSid' => 'UGp8wc83W3GzrSmORNwo9EOVg1ijNv',
                'Recipient' => $leaflet['participant']['mobile'],
                'Body' => 'عزيزي '. $leaflet['participant']['fullname'].', الان يمكنك استخدام الرمز السري التالي '.$leaflet->code.' عبر الموقع الالكتروني',
              ]
          ]);
        }

      } catch (ModelNotFoundException $ex) {
       return response()->json('error', 422);
      }
      return response()->json(true);
    }

    public function rejectHelp(Request $request) {
      $user = auth()->user();

      $leaflet = HelpDesk::with(['leaflet','participant'])
      ->where('id', $request->id)->first();

      HelpDesk::where('id', $request->id)->update(['rejected_by' => $user->id]);
      HelpDesk::where('id', $request->id)->delete();

      try {
        $client = new Client();

        if($leaflet['participant']['locale'] === 'en'){
          $response = $client->request('POST', 'http://api.unifonic.com/rest/Messages/Send', [
              'form_params' => [
                'AppSid' => 'UGp8wc83W3GzrSmORNwo9EOVg1ijNv',
                'Recipient' => $leaflet['participant']['mobile'],
                'Body' => 'Dear '. $leaflet['participant']['fullname'].', Your complaint was rejected because your provided code '.$leaflet->code.' does not match with the uploaded image',
              ]
          ]);
        }
        if($leaflet['participant']['locale'] === 'ar'){
          $response = $client->request('POST', 'http://api.unifonic.com/rest/Messages/Send', [
              'form_params' => [
                'AppSid' => 'UGp8wc83W3GzrSmORNwo9EOVg1ijNv',
                'Recipient' => $leaflet['participant']['mobile'],
                'Body' => 'عزيزي '. $leaflet['participant']['fullname'].', تم رفض الشكوى بسبب عدم تطابق الصورة المرفقة مع الكود المدخل '.$leaflet->code.' مسبقا. يرجى التأكد من رفع الصورة الصحيحة',
              ]
          ]);
        }

      } catch (ModelNotFoundException $ex) {
       return response()->json('error', 422);
      }
      return response()->json(true);
    }

    public function approvedModeration(Request $request){
      $model = new LeafletsModeration();

      if($request['search']){
          $participants = $model::with(['leaflet','leaflet.participant','leaflet.participant.city','leaflet.voucher','upload','moderator_accepted'])
          ->whereHas('leaflet.participant', function ($query) use($request){
            $mobile = preg_replace('/^(009665|9665|\+9665|05|5)/', '9665', $request['search']);
            $query->where('mobile','LIKE','%'.$mobile.'%');
          })
          ->where('approved', 1)
          ->whereNull('deleted_at')
    			->orderBy('updated_at', 'DESC')->paginate(32);

          $response = [
            'pagination' => [
                'total' => $participants->total(),
                'per_page' => $participants->perPage(),
                'current_page' => $participants->currentPage(),
                'last_page' => $participants->lastPage(),
                'from' => $participants->firstItem(),
                'to' => $participants->lastItem()
            ],
              'data' => $participants->toArray(),
          ];
        } else {
          $participants = $model::with(['leaflet','leaflet.participant','leaflet.voucher','upload','moderator_accepted'])
          ->where('approved', '=', 1)
          ->whereNull('deleted_at')
    			->orderBy('updated_at', 'DESC')->paginate(32);

          $response = [
            'pagination' => [
                'total' => $participants->total(),
                'per_page' => $participants->perPage(),
                'current_page' => $participants->currentPage(),
                'last_page' => $participants->lastPage(),
                'from' => $participants->firstItem(),
                'to' => $participants->lastItem()
            ],
              'data' => $participants->toArray(),
          ];
        }
        return response()->json($response);
    }

	public function rejectedModeration(Request $request)
    {

      $model = new LeafletsModeration();

		if($request['search']){
			$participants = $model::onlyTrashed()->with(['leaflet','leaflet.participant' => function ($query) {
        $query->withTrashed();
			},'leaflet.participant.city','leaflet.voucher','upload' => function ($query) {
				$query->onlyTrashed();
			},'moderator_rejected'])
			->whereHas('leaflet.participant', function ($query) use($request){
        $mobile = preg_replace('/^(009665|9665|\+9665|05|5)/', '9665', $request['search']);
        $query->where('mobile','LIKE','%'.$mobile.'%');
			})
            ->whereNotNull('rejected_by')
            ->whereNotNull('deleted_at')
      			->orderBy('deleted_at', 'DESC')->paginate(32);

            $response = [
	            'pagination' => [
	                'total' => $participants->total(),
	                'per_page' => $participants->perPage(),
	                'current_page' => $participants->currentPage(),
	                'last_page' => $participants->lastPage(),
	                'from' => $participants->firstItem(),
	                'to' => $participants->lastItem()
	            ],
                'data' => $participants->toArray(),
            ];
        } else {
          $participants = $model::onlyTrashed()->with(['leaflet' => function ($query) {
  				$query->onlyTrashed();
    			},'leaflet.participant' => function ($query) {
    				$query->withTrashed();
    			}, 'leaflet.participant.city','leaflet.voucher','upload' => function ($query) {
    				$query->onlyTrashed();
    			},'moderator_rejected'])
            ->whereNotNull('rejected_by')
            ->whereNotNull('deleted_at')
			      ->orderBy('deleted_at', 'DESC')->paginate(32);


            $response = [
	            'pagination' => [
	                'total' => $participants->total(),
	                'per_page' => $participants->perPage(),
	                'current_page' => $participants->currentPage(),
	                'last_page' => $participants->lastPage(),
	                'from' => $participants->firstItem(),
	                'to' => $participants->lastItem()
	            ],
                'data' => $participants->toArray(),
            ];
        }
        return response()->json($response);
    }

        public function rejectModeration(Request $request){
	  	    $user = auth()->user();

			LeafletsModeration::where('id', $request->id)->delete();
			LeafletsModeration::withTrashed()->where('id', $request->id)->update(['rejected_by' => $user->id]);
			$leaflet = LeafletsModeration::withTrashed()->where('id', $request['id'])->first();
			Leaflets::where('id', $leaflet->leaflet_id)->delete();
			LeafletsUpload::where('leaflet_id', $leaflet->leaflet_id)->delete();

    		$participant = Leaflets::withTrashed()->where('id', $leaflet->leaflet_id)->with('participant')->first();

		    VoucherCodes::where('id', $participant->online_raffle)->update(['status' => '0']);

    		$client = new Client();
    		if($participant['participant']['locale'] === 'en'){
    			$response = $client->request('POST', 'http://api.unifonic.com/rest/Messages/Send', [
    			    'form_params' => [
    				    'AppSid' => 'UGp8wc83W3GzrSmORNwo9EOVg1ijNv',
  				       'Recipient' => $participant['participant']['mobile'],
    				    'Body' => 'Sorry '.$participant['participant']['fullname'].' ! The picture with the paper code '.$participant['code'].' you submitted does not meet our terms & conditions mentioned in the website. Please make sure that you upload the right picture and make sure to match to code that you entered before',
    			    ]

    			]);
    		}
    		if($participant['participant']['locale'] === 'ar'){
    			$response = $client->request('POST', 'http://api.unifonic.com/rest/Messages/Send', [
    			    'form_params' => [
    				    'AppSid' => 'UGp8wc83W3GzrSmORNwo9EOVg1ijNv',
    				    'Recipient' => $participant['participant']['mobile'],
                'Body' => 'عفواً '.$participant['participant']['fullname'].' ! الصورة التي قمت بإرسالها لا تتوافق مع الشروط والأحكام المذكورة في الموقع يرجى التأكد من رفع الصورة الصحيحة و المطابقة للكود المدخل '. $participant['code'],
    			    ]
    			]);
    		}

    		return response()->json(true);
      }

      public function acceptModeration(Request $request) {
	    $user = auth()->user();
 			$client = new Client();

      LeafletsModeration::where('id', $request->id)->update(['approved' => 1,'approved_by' => $user->id]);

      $leaflet = LeafletsModeration::where('id', $request->id)->with('leaflet')->first();
 			$participant = Leaflets::with(['gift','voucher'])->where('id', $leaflet->leaflet_id)->first();
 			$mobile = preg_replace('/^(966)/', '0', $participant['participant']['mobile']);
      $gift = $participant['voucher']['code'];
      $giftId = $participant['online_raffle'];
      $voucher = VoucherCodes::where('id', $giftId)->with('voucher')->first();
      $giftName = $voucher['voucher']['image'];

        if (strpos($giftName, 'st') !== false) {
    		    try {
    				$client = new Client();
    				if($participant['participant']['locale'] === 'en'){
    					$response = $client->request('POST', 'http://api.unifonic.com/rest/Messages/Send', [
    					    'form_params' => [
    						    'AppSid' => 'UGp8wc83W3GzrSmORNwo9EOVg1ijNv',
    						    'Recipient' => $participant['participant']['mobile'],
    						    'Body' => 'Dear '. $participant['participant']['fullname'].', Thank you for claiming your prize, Please use this code '.$gift.' on https://bit.ly/3yKLXDR while signing up as a new user. Learn how to redeem your code: https://bit.ly/3jXgDLR',
    					    ]
    					]);
    				}
    				if($participant['participant']['locale'] === 'ar'){
    					$response = $client->request('POST', 'http://api.unifonic.com/rest/Messages/Send', [
    					    'form_params' => [
    						    'AppSid' => 'UGp8wc83W3GzrSmORNwo9EOVg1ijNv',
    						    'Recipient' => $participant['participant']['mobile'],
    						    'Body' => 'عزيزي '. $participant['participant']['fullname'] .', يرجى استخدام الرمز التالي '.$gift.' عبر الموقع https://bit.ly/3yKLXDR عبر التسجيل كمستخدم جديد. لمعرفة كيفية استخدام القسيمة: https://bit.ly/3jRK3e7',
    					    ]
    					]);
    				}

    			} catch (ModelNotFoundException $ex) {
    				 return response()->json('error', 422);
    			}
  		}

      if (strpos($giftName, 'tru') !== false) {
          try {
          $client = new Client();
          if($participant['participant']['locale'] === 'en'){
            $response = $client->request('POST', 'http://api.unifonic.com/rest/Messages/Send', [
  					    'form_params' => [
  						    'AppSid' => 'UGp8wc83W3GzrSmORNwo9EOVg1ijNv',
  						    'Recipient' => $participant['participant']['mobile'],
  						    'Body' => 'Dear '. $participant['participant']['fullname'] .', Please use this voucher '.$gift.' on https://www.toysrus.com.sa while checking out.',
  					    ]
  					]);
          }
          if($participant['participant']['locale'] === 'ar'){
            $response = $client->request('POST', 'http://api.unifonic.com/rest/Messages/Send', [
  					    'form_params' => [
  						    'AppSid' => 'UGp8wc83W3GzrSmORNwo9EOVg1ijNv',
  						    'Recipient' => $participant['participant']['mobile'],
  						    'Body' => 'عزيزي '. $participant['participant']['fullname'] .', الان يمكنك اختيار جائزتك من تويز ار اص https://www.toysrus.com.sa  باستخدام القسيمة الالكترونية التالية '.$gift,
  					    ]
  					]);
          }

        } catch (ModelNotFoundException $ex) {
           return response()->json('error', 422);
        }
    }
 			return response()->json(true);
 		}

    // Inventory

    public function inventory(Request $request){

		if($request['search']){

			$inventory = Gifts::withCount('consumed')->with('allocation')
			->where('name','LIKE','%'.$request['search'].'%')
            ->orderBy('id', 'ASC')->paginate(10);

            $response = [
	            'pagination' => [
	                'total' => $inventory->total(),
	                'per_page' => $inventory->perPage(),
	                'current_page' => $inventory->currentPage(),
	                'last_page' => $inventory->lastPage(),
	                'from' => $inventory->firstItem(),
	                'to' => $inventory->lastItem()
	            ],
                'data' => $inventory->toArray(),
            ];
        } else {
			$inventory = Gifts::withCount('consumed')->with('allocation')
            ->orderBy('id', 'ASC')->paginate(10);

            $response = [
	            'pagination' => [
	                'total' => $inventory->total(),
	                'per_page' => $inventory->perPage(),
	                'current_page' => $inventory->currentPage(),
	                'last_page' => $inventory->lastPage(),
	                'from' => $inventory->firstItem(),
	                'to' => $inventory->lastItem()
	            ],
                'data' => $inventory->toArray(),
            ];
        }
        return response()->json($response);
    }

    public function inventoryUpdate(Request $request){
		$inventory = array();
		foreach ($request->inventory as $key => $value){
			if(strpos($key, 'location') !== false){
				 $inventory[$key]['location_id'] = str_replace("location", "", $key);
				 $inventory[$key]['qty'] = $value;
				 $inventory[$key]['gift_id'] = $request->inventory["id"];
			}
		}
		foreach ($inventory as $key => $value){
			$gift_allocation = GiftsAllocation::where('gift_id', $value['gift_id'])
			->where('location_id', $value['location_id'])
			->first();

			if ($gift_allocation !== null) {
				$gift_allocation->update(['gift_id' => $value['gift_id'],'location_id' => $value['location_id'],'qty' => $value['qty']]);
			} else {
			    $gift_allocation = GiftsAllocation::create(['gift_id' => $value['gift_id'],'location_id' => $value['location_id'],'qty' => $value['qty']]);
			}
	    }
    }


    public function FixIT(Request $request){
      $getCodes = Leaflets::whereNotNull('online_raffle')
      ->whereNull('type')
      ->update(['type' => 'voucher'], ['timestamps' => false]);

      $relatedIds = Leaflets::doesntHave('participant')->pluck('id');
      Leaflets::whereIn('id',$relatedIds)->delete();

      $relatedIds = Leaflets::whereNotNull('instant_gift')->pluck('instant_gift');
	  VoucherCodes::where('voucher_id','1')->whereNotIn('id', $relatedIds)->update(['status' => '0']);

	  $relatedIds = Leaflets::whereNotNull('online_raffle')
		->orWhere('type','voucher')
		->orWhere('type','Voucher')
		->pluck('online_raffle');
	  VoucherCodes::whereNotIn('voucher_id',['1'])->whereNotIn('id', $relatedIds)->update(['status' => '0']);
    }


    public function RemoveParticipant(Request $request)
      {
        Participant::where('id', $request->id)->delete();
        $getCodes = Leaflets::where('participant_id', $request->id)->pluck('id');
        $getCodeType = Leaflets::where('participant_id', $request->id)->get();
        Leaflets::where('participant_id', $request->id)->delete();

        if($getCodes){
          foreach ($getCodeType as $leaflet) {
            if($leaflet->type === 'voucher'){
              VoucherCodes::where('id', $leaflet->online_raffle)->update(['status' => '0']);
            }
            if($leaflet->type === 'voucher'){
              VoucherCodes::where('id', $leaflet->online_raffle)->update(['status' => '0']);
            }
          }
          try {
            LeafletsModeration::whereIn('leaflet_id',$getCodes)->delete();
      		} catch (ModelNotFoundException $ex) {}
            try {
              LeafletsUpload::whereIn('leaflet_id', $getCodes)->delete();
        		} catch (ModelNotFoundException $ex) {}
        }
        return response()->json(true);
      }

      public function RemoveParticipantLeaflet(Request $request)
        {
//            dd($request->id);
          $getCode = Leaflets::where('id', $request->id)->first();
          Leaflets::where('id', $request->id)->delete();
          if($getCode->type === 'voucher'){
            VoucherCodes::where('id', $getCode->online_raffle)->update(['status' => '0']);
          }
          LeafletsModeration::where('leaflet_id',$request->id)->delete();
          LeafletsUpload::where('leaflet_id', $request->id)->delete();
          return response()->json(true);
        }

      public function banMobile(Request $request){
        Participant::where('id', $request->id)->update(['ban' => 1]);

        $getCodes = Leaflets::where('participant_id', $request->id)->pluck('id');
        $getCodeType = Leaflets::where('participant_id', $request->id)->get();
        Leaflets::where('participant_id', $request->id)->delete();

        if($getCodes){
          foreach ($getCodeType as $leaflet) {
            if($leaflet->type === 'voucher'){
              VoucherCodes::where('id', $leaflet->online_raffle)->update(['status' => '0']);
            }
          }
          try {
            LeafletsModeration::whereIn('leaflet_id',$getCodes)->delete();
      		} catch (ModelNotFoundException $ex) {}
            try {
              LeafletsUpload::whereIn('leaflet_id', $getCodes)->delete();
        		} catch (ModelNotFoundException $ex) {}
        }

        return response()->json(true);
      }

	// Dashboard

	public function stat(Request $request) {

		$total = Participant::get()->count();
		$registered_today = Participant::whereDate('created_at', Carbon::today())->count();
		$registered_yesterday = Participant::whereDate('created_at', date("Y-m-d", strtotime( '-1 days' ) ))->count();

		$collectionQuery = Participant::all();

		$language = $collectionQuery->groupBy('locale')->map(function($values) {
		    return $values->count();
		})->sort()->reverse();

		$city = DB::table('participants as a')
	    ->leftJoin('cities as b', 'a.city', '=', 'b.id')
	    ->select(DB::raw("b.name as city"), DB::raw('COUNT(*) as participants'))
	    ->groupBy(DB::raw("city"))
	    ->get();

	    $daily_locations = DB::table('leaflets as a')
	    ->leftJoin('locations as b', 'a.location_id', '=', 'b.id')
	    ->select(DB::raw("b.description as location"), DB::raw('COUNT(*) as leaflets'))
	    ->groupBy(DB::raw("location"))
	    ->get();
	    // $city = $collectionQuery->groupBy('city')->map(function($values) {
			//     return $values->count();
			// })->sort()->reverse();

	    $age = DB::table('participants')
	    ->select(DB::raw("age"), DB::raw('COUNT(*) as participants'))
	    ->groupBy(DB::raw("age"))
	    ->get();

		// $age = $collectionQuery->groupBy('age')->map(function($values) {
		//     return $values->count();
		// })->sort()->reverse();

// 		$leaflets_consumed =  Leaflets::whereNotNull('code')->count();
		$leaflets_pending =  Leaflets::whereNull('code')->count();
		$leaflets_consumed =  Leaflets::whereNotNull('code')->count();

		$leaflets_instant =  Leaflets::whereNotNull('instant_gift')->count();
		$leaflets_without_instant =  Leaflets::whereNull('instant_gift')->count();

// 		$leaflets_consumed =  Leaflets::all()->count();

		$total_gifts = GiftsAllocation::all()->sum('qty');

		$consumed_gifts = Leaflets::where('type','gift')->whereNotNull('location_id')->whereNotNull('online_raffle')->count();

		$going_tru = Leaflets::whereNotNull('location_id')->count();

		$total_stg_7 = VoucherCodes::where('voucher_id','1')->count();
		$remaining_stg_7 = VoucherCodes::where('voucher_id','1')->where('status','1')->count();

		$total_stg_1 = VoucherCodes::where('voucher_id','2')->count();
		$remaining_stg_1 = VoucherCodes::where('voucher_id','2')->where('status','1')->count();

		$total_stg_6 = VoucherCodes::where('voucher_id','3')->count();
		$remaining_stg_6 = VoucherCodes::where('voucher_id','3')->where('status','1')->count();

		$online_raffle =  Leaflets::whereNotNull('online_raffle')->count();
		$online_raffle_pending =  Leaflets::whereNull('online_raffle')->count();

	    $tru = Cities::where('type' ,'store')->pluck('id')->toArray();
	    $non_tru = Cities::where('type' ,'online')->pluck('id')->toArray();

	    $leaflet = Leaflets::where('code',$request->leaflet)->whereNotNull('location_id')->first();

	    $tru_cities =  Participant::whereIn('city',$tru)->count();
	    $non_tru_cities =  Participant::whereIn('city',$non_tru)->count();
	    $no_city =  Participant::whereNull('city')->count();

	    $banned =  Participant::where('ban','1')->count();

	    $old_participants =  LeafletsModeration::all()->pluck('leaflet_id');
	    $old_participants =  Leaflets::whereNotIn('id',$old_participants)->count();

	    $pending = LeafletsModeration::where('uploaded','1')->where('approved','0')->count();
	    $approved = LeafletsModeration::where('uploaded','1')->where('approved','1')->count();
	    $rejected = LeafletsModeration::onlyTrashed()->where('uploaded','1')->count();


	    $from = date('2021-08-15');
	    $to = date('2021-08-31');

	    $oldstatus =  Leaflets::whereNotNull('location_id')
	    ->whereNotNull('code')
	    ->whereNull('online_raffle')
	    ->whereBetween('updated_at', [$from, $to])
	    ->orderBy('created_at', 'DESC')->count();

	    // $product = Participants::withCount(['Response as response_count', 'Gender as male_count' => function ($q) {
	    //     $q->where('gender','male');
	    // },'Gender as female_count' => function ($q) {
	    //     $q->where('gender','female');
	    // }])
	    // ->orderBy('response_count', 'desc')
	    // ->get();

	    $daily_participations = DB::table('participants')->select(DB::raw("DATE(created_at) as created_at"), DB::raw('COUNT(*) as participants'))->
	              groupBy(DB::raw("DATE(created_at)"))->
	              get();
	    $daily_leaflets = DB::table('leaflets')->select(DB::raw("DATE(created_at) as created_at"), DB::raw('COUNT(*) as leaflets'))->
	              groupBy(DB::raw("DATE(created_at)"))->
	              get();



    // $daily_locations = DB::table('leaflets as a')
    //                   ->leftJoin('locations as b', 'a.location_id', '=', 'b.id')
    //                   ->select([DB::raw("DATE(a.created_at) as created_at"), DB::raw("b.description as location"), DB::raw('COUNT(*) as leaflets')])
    //                   ->groupBy([DB::raw("location"), DB::raw("DATE(a.created_at)")])
    //                   // ->groupBy(DB::raw("DATE(created_at)"))
    //                   ->get();

    // $customers = SurveyResponse::where('survey_id',$request->input('survey'))->pluck('customer_id');
    // $customer = [
    //     Customer::whereIn('id',$customers)->where('gender','male')->count(),
    //     Customer::whereIn('id',$customers)->where('gender','female')->count()
    // ];
    //
    // $customer = implode(", ",$customer);

		$response = [
			'daily_participations' => $daily_participations,
			'daily_leaflets' => $daily_leaflets,
			'total' => $total,
			'city' => $city,
			'language' => $language,
			'age' => $age,
			'leaflets_pending' => $leaflets_pending,
			'leaflets_consumed' => $leaflets_consumed,
			'leaflets_instant' => $leaflets_instant,
			'leaflets_without_instant' => $leaflets_without_instant,
			'total_gifts' => $total_gifts,
			'consumed_gifts' => $consumed_gifts,
			'total_stg_7' => $total_stg_7,
			'remaining_stg_7' => $total_stg_7 - $remaining_stg_7,
			'total_stg_1' => $total_stg_1,
			'remaining_stg_1' => $total_stg_1 - $remaining_stg_1,
			'total_stg_6' => $total_stg_6,
			'remaining_stg_6' => $total_stg_6 - $remaining_stg_6,
			'online_raffle' => $online_raffle,
			'online_raffle_pending' => $online_raffle_pending,
			'going_tru' => $going_tru,
			'registered_today' => $registered_today,
			'registered_yesterday' => $registered_yesterday,
			'oldstatus' => $oldstatus,
			'tru_cities' => $tru_cities,
			'non_tru_cities' => $non_tru_cities,
			'no_city' => $no_city,
			'banned' => $banned,
			'old_participants' => $old_participants,
			'pending' => $pending,
			'approved' => $approved,
			'rejected' => $rejected,
			'daily_locations' => $daily_locations,
        ];

        return response()->json($response);
	}


	// Export
	public function week_incomplete_registrations(Request $request) {
        $model = new ParticipantFiles();

		$week_incomplete_mission = $model::with(['participant'])
        ->whereNull('file_id')
        ->whereNull('deleted_at')
		->orderBy('created_at', 'DESC')->get();


		if(count($week_incomplete_mission)){
			(new FastExcel($week_incomplete_mission))->export('soty_2020_without_drawings.xlsx', function ($user) {
			    return [
			        'Mobile' => $user['participant']['mobile'],
			        'First Name' => $user['participant']['first_name'] ? $user['participant']['first_name'] : 'null',
			        'Middle Name' => $user['participant']['middle_name'] ? $user['participant']['middle_name'] : 'null',
			        'Last Name' => $user['participant']['last_name'] ? $user['participant']['last_name'] : 'null',
			        'City' => $user['participant']['city'] == 0 ? ucfirst($user['participant']['othercity']) : ucfirst($user['participant']['CityName']),
			    ];
			});
		    return response()->download('soty_2020_without_drawings.xlsx');
	    }
	        return response()->json('No download found for this week');
	}

	public function week_complete_registrationss(Request $request) {
        $model = new ParticipantFiles();

		$week_complete_mission = $model::with(['participant'=> function ($query) {
			$query->whereNotNull('city');
		}])
		->Wherehas('participant.city')
        ->whereNotNull('file_id')
        ->whereNull('deleted_at')
		->orderBy('created_at', 'DESC')->get();

		if(count($week_complete_mission)){
			(new FastExcel($week_complete_mission))->export('soty_2020_with_drawings.xlsx', function ($user) {
			    return [
			        'Mobile' => $user['participant']['mobile'],
			        'First Name' => $user['participant']['first_name'],
			        'Middle Name' => $user['participant']['middle_name'],
			        'Last Name' => $user['participant']['last_name'],
			        'City' => $user['participant']['city'] == 0 ? ucfirst($user['participant']['othercity']) : ucfirst($user['participant']['CityName']),
			    ];
			});
		    return response()->download('soty_2020_with_drawings.xlsx');
	    }
	        return response()->json('No download found for this week');
	}

	public function week_numbers(Request $request) {
        $model = new ParticipantFiles();

		$week_all_registrations = $model::withTrashed()->with(['participant','moderator_rejected','moderator_accepted'])
		->orderBy('created_at', 'DESC')->get();

// 	    return response()->json($week_all_registrations);

		if(count($week_all_registrations)){
			(new FastExcel($week_all_registrations))->export('verified_numbers.xlsx', function ($user) {
			    return [
			        'Mobile' => $user['participant']['mobile'],
			        'First Name' => $user['participant']['first_name'],
			        'Middle Name' => $user['participant']['middle_name'],
			        'Last Name' => $user['participant']['last_name'],
			        'Age' => $user['participant']['age'],
			        'City' => $user['participant']['city'] == 0 ? ucfirst($user['participant']['othercity']) : ucfirst($user['participant']['CityName']),
			        'Mission' => empty($user['file_id']) ? 'No' : 'Yes',
			        'Approved' => $user['approved'] == 0 ? 'No' : 'Yes',
			        'Moderated By' => !empty($user['moderator_accepted']) ? $user['moderator_accepted']['name'] : (!empty($user['moderator_rejected']) ? $user['moderator_rejected']['name'] : 'None'),
			        'Created' => $user['CreatedTime'],
			        'Updated' => $user['UpdatedTime'],
			    ];
			});
		    return response()->download('verified_numbers.xlsx');
	    }
	        return response()->json('No download found for this week');
	}

	public function all_week_numbers(Request $request) {
        $model = new Participant();

		$week_all_registrations = $model::with('getCity')->orderBy('created_at', 'ASC')->get();

		if(count($week_all_registrations)){
			(new FastExcel($week_all_registrations))->export('all_verified_mobile_numbers.xlsx', function ($user) {
			    return [
			        'Full Name' => $user['first_name'] == '' ? 'NULL' : $user['first_name'].' '.$user['last_name'],
			        'First Name' => $user['first_name'] == '' ? 'NULL' : $user['first_name'],
			        'Last Name' => $user['last_name'] == '' ? 'NULL' : $user['last_name'],
			        'Mobile' => $user['mobile'],
			        'City' => $user['city'] == '' ? 'NULL' : ucfirst($user['getCity']['name']),
			        'Age' => $user['age'] == '' ? 'NULL' : $user['age'],
			        'Birth Year' => (2021 - $user['age'] == 2021) ? 'NULL' : 2021 - $user['age'],
			    ];
			});
		    return response()->download('all_verified_mobile_numbers.xlsx');
	    }
	        return response()->json('No download found for this week');
	}

	public function all_for_crm(Request $request) {
        $model = new Participant();

		$week_all_registrations = $model::with('getCity')->orderBy('created_at', 'ASC')->get();

		if(count($week_all_registrations)){
			(new FastExcel($week_all_registrations))->export('all_for_crm.xlsx', function ($user) {
			    return [
			        'Full Name' => $user['first_name'] == '' ? 'NULL' : $user['first_name'].' '.$user['last_name'],
			        'First Name' => $user['first_name'] == '' ? 'NULL' : $user['first_name'],
			        'Last Name' => $user['last_name'] == '' ? 'NULL' : $user['last_name'],
			        'Mobile' => $user['mobile'],
			        'City' => $user['city'] == '' ? 'NULL' : ucfirst($user['getCity']['name']),
			        'Age' => $user['age'] == '' ? 'NULL' : $user['age'],
			        'Birth Year' => (2021 - $user['age'] == 2021) ? 'NULL' : 2021 - $user['age'],
			    ];
			});
		    return response()->download('all_for_crm.xlsx');
	    }
	        return response()->json('No download found for this week');
	}

     public function fetchgifts(Request $request)
     {
		$avaGifts = array();
	    $Gifts = Gifts::all();
	    foreach($Gifts as $gift){
		    if($gift->id == 1 && Winners::where('gift_id',1)->count() <= 10){
			    $avaGifts[] = $gift->id;
		    }
		   if($gift->id == 2 && Winners::where('gift_id',2)->count() <= 50){
			    $avaGifts[] = $gift->id;
		    }
		    if($gift->id == 3 && Winners::where('gift_id',3)->count() <= 100){
			    $avaGifts[] = $gift->id;
		    }
		     if($gift->id == 4 && Winners::where('gift_id',4)->count() <= 500){
			    $avaGifts[] = $gift->id;
		    }
	    }
	    $winners = Gifts::whereIn('id', $avaGifts)->get();
		return response()->json($winners);
     }

     public function selectwinner(Request $request)
     {
	 	$selectedWinners = Winners::pluck('participant_id')->all();
	    $winner = ParticipantFiles::with(['participant','uploads'])
	    ->inRandomOrder()
		->where('file_id', '>', 0)
		->where('approved', '=', 1)
		->whereNull('deleted_at')
		->whereNotIn('participant_id', $selectedWinners)->first();

		return response()->json($winner);
     }

     public function selectwinnerAccept(Request $request)
     {
		$winner = new Winners;
        $winner->participant_id = $request['id'];
        $winner->save();
		return response()->json(true);
     }


     public function winnerslistRemove(Request $request)
     {
		Winners::where('id', $request['id'])->delete();
		return response()->json(true);
     }

     public function winnerslistFav(Request $request)
     {
		Winners::where('id',$request['id'])->update(['fav' => $request['toggle']]);
		return response()->json(true);
     }

     public function winnerslist(Request $request)
     {
		$model = new Winners();
		if($request['search']){
			if(is_numeric($request['search'])){
				$participants = $model::with(['participant','participant.participant','participant.uploads','gift'])
				->whereHas('participant.participant', function ($query) use($request){
				  $query->where('mobile','LIKE','%'.$request['search'].'%');
				})
	            ->orderBy('gift_id', 'ASC')->paginate(16);
			} else {
				$participants = $model::with(['participant','participant.participant.city','participant.participant','participant.uploads','gift'])
				->whereHas('participant.participant.city', function ($query) use($request){
				  if (strpos($request['search'], ',') !== false) {
						$search = explode(",", $request['search']);
						$query->where('name','=', $search[0])
							->orWhere('name', '=', $search[1]);
					} else {
						$query->where('name','=', $request['search']);
					}
				})
	            ->orderBy('gift_id', 'ASC')->paginate(16);
			}

            $response = [
	            'pagination' => [
	                'total' => $participants->total(),
	                'per_page' => $participants->perPage(),
	                'current_page' => $participants->currentPage(),
	                'last_page' => $participants->lastPage(),
	                'from' => $participants->firstItem(),
	                'to' => $participants->lastItem()
	            ],
                'data' => $participants->toArray(),
            ];
        } else {
			$participants = $model::with(['participant','participant.participant','participant.uploads','gift'])
            ->orderBy('gift_id', 'ASC')->paginate(16);

            $response = [
	            'pagination' => [
	                'total' => $participants->total(),
	                'per_page' => $participants->perPage(),
	                'current_page' => $participants->currentPage(),
	                'last_page' => $participants->lastPage(),
	                'from' => $participants->firstItem(),
	                'to' => $participants->lastItem()
	            ],
                'data' => $participants->toArray(),
            ];
        }
        return response()->json($response);
     }


     public function winnerslistDownload(Request $request)
     {

        $winners = Winners::pluck('participant_id')->all();

        $model = new ParticipantFiles();

		$week_all_registrations = $model::whereIn('id', $winners)->with(['participant','uploads','gifts.gift'])
		->orderBy('created_at', 'DESC')->get();

		$final = $week_all_registrations->unique('participant_id');

		if(count($final)){
			(new FastExcel($final))->export('winners_list_sunwinners.xlsx', function ($user) {

			    return [
			        'Drawing' => "https://soty.suntop.com.sa/uploaded/image/" . $user['uploads']['name'] . "." . $user['uploads']['extension'],
			        'Mobile' => $user['participant']['mobile'],
			        'First Name' => $user['participant']['first_name'],
			        'Middle Name' => $user['participant']['middle_name'],
			        'Last Name' => $user['participant']['last_name'],
			        'Age' => $user['participant']['age'],
			        'City' =>  ucfirst($user['participant']['CityName']),
			    ];
			});
		    return response()->download('winners_list_sunwinners.xlsx');
	    }
	        return response()->json('Winners list is empty');
     }

     public function weekly_winners(Request $request)
     {
	    $winners = Temporary::all();
	    foreach ($winners as $winner) {
    		$participant = Participant::where('mobile', $winner->mobile)->first();
    		Winners::create(['participant_id' => $participant->id,'gift_id' => $winner->gift]);
		}
     }

     public function cities(Request $request)
	    {
		    $cities = App\Models\Cities::all();
	        return response()->json($cities);
		}

	public function locations(Request $request)
	{
		$loc = App\Models\Locations::all();
		return response()->json($loc);
	}

	public function ExportTru(Request $request) {
        $model = new Leaflets();

		$week_all_registrations = $model::with(['participant','gift','location'])->whereNotNull('location_id')
		->orderBy('created_at', 'DESC')->get();

		if(count($week_all_registrations)){
			(new FastExcel($week_all_registrations))->export('tru_numbers.xlsx', function ($user) {
			    return [
			        'Mobile' => empty($user['participant']['mobile']) ? '' : $user['participant']['mobile'],
			        'Code' => $user['code'],
			        'Serial' => $user['serial'],
			        'Location' => $user['location']['description'],
			        'Full Name' => empty($user['participant']['fullname']) ? '' : $user['participant']['fullname'],
			        'Age' => empty($user['participant']['age']) ? '' : $user['participant']['age'],
			        'Gift Type' => empty($user['type']) ? 'old' : $user['type'],
			        'Claimed' => $user['claimed'] == 0 ? 'No' : 'Yes',
			        'Created' => $user['CreatedTime'],
			        'Updated' => $user['UpdatedTime'],
			    ];
			});
		    return response()->download('tru_numbers.xlsx');
	    }
	        return response()->json('No download found for this week');
	}


  public function WinnersPending(Request $request){
        $leaflets = Leaflets::whereHas('winners', function($query){
          $query->where('claimed',1);
        })->where('type','gift')->whereNotNull('online_raffle')->pluck('id');


        $participants = Leaflets::with([
        'winners','participant','participant.getCity','gift','location'
        ])->whereNotIn('id',$leaflets)->where('type','gift')->whereNotNull('online_raffle')->get();

      $response = [
          'data' => $participants->toArray()
      ];
      return response()->json($response);
  }

  public function WinnersClaimed(Request $request){
      $participants = Leaflets::whereHas('winners', function($query){
        $query->where('claimed',1);
      })->with('winners','participant','participant.getCity','gift','location')->where('type','gift')->whereNotNull('online_raffle')->get();

      $response = [
          'data' => $participants->toArray()
      ];
      return response()->json($response);
  }

  public function ExportGifts(Request $request) {
    $model = new Gifts();

		$week_all_registrations = $model::withCount('consumed')->withSum('allocation','qty')->with('allocation')
    ->get();

		if(count($week_all_registrations)){
			(new FastExcel($week_all_registrations))->export('suncola_gifts_inventory.xlsx', function ($user) {
			    return [
			   'Gift Name' => $user['name'],
              'Total QTY' => $user['allocation_sum_qty'],
              'Consumed QTY' => $user['consumed_count'],
              'Remaining QTY' => $user['allocation_sum_qty'] - $user['consumed_count'],
              'Claimed QTY' => count($user['Claimed']),
              'Pending Claim QTY' => $user['consumed_count'] - count($user['Claimed']),
			    ];
			});
		    return response()->download('suncola_gifts_inventory.xlsx');
	    }
	        return response()->json('No download found for this week');
	}

  public function ExportPendingWinners(Request $request) {
    $model = new Leaflets();
    $leaflets = $model::whereHas('winners', function($query){
      $query->where('claimed',1);
    })
    ->where('type','gift')
    ->whereNotNull('online_raffle')->pluck('id');

		$week_all_registrations = $model::with(['participant','location','gift'])
    ->whereNotIn('id',$leaflets)
    ->where('type','gift')
    ->whereNotNull('online_raffle')
    ->get();

		if(count($week_all_registrations)){
			(new FastExcel($week_all_registrations))->export('pending_winners.xlsx', function ($user) {
			    return [
			        'Mobile' => empty($user['participant']['mobile']) ? '' : $user['participant']['mobile'],
			        'Location' => $user['location']['description'],
			        'Full Name' => empty($user['participant']['fullname']) ? '' : $user['participant']['fullname'],
			        'Age' => empty($user['participant']['age']) ? '' : $user['participant']['age'],
              'Gift' => empty($user['gift']) ? '' : $user['gift']['name'],
              'Language' => empty($user['participant']['locale']) ? '' : $user['participant']['locale'],
			        'Created' => $user['CreatedTime'],
			        'Last Updated' => $user['UpdatedTime'],
			    ];
			});
		    return response()->download('pending_winners.xlsx');
	    }
	        return response()->json('No download found for this week');
	}

  public function ExportClaimedWinners(Request $request) {
    $model = new Leaflets();

		$week_all_registrations = $model::whereHas('winners', function($query){
      $query->where('claimed',1);
    })
    ->with(['participant','location','gift'])
    ->where('type','gift')
    ->whereNotNull('online_raffle')
    ->get();

		if(count($week_all_registrations)){
			(new FastExcel($week_all_registrations))->export('claimed_winners.xlsx', function ($user) {
			    return [
			        'Mobile' => empty($user['participant']['mobile']) ? '' : $user['participant']['mobile'],
			        'Location' => $user['location']['description'],
			        'Full Name' => empty($user['participant']['fullname']) ? '' : $user['participant']['fullname'],
			        'Age' => empty($user['participant']['age']) ? '' : $user['participant']['age'],
              'Gift' => empty($user['gift']) ? '' : $user['gift']['name'],
              'Language' => empty($user['participant']['locale']) ? '' : $user['participant']['locale'],
			        'Created' => $user['CreatedTime'],
			        'Last Updated' => $user['UpdatedTime'],
			    ];
			});
		    return response()->download('claimed_winners.xlsx');
	    }
	        return response()->json('No download found for this week');
	}

  public function ExportAllWinners(Request $request) {
    $model = new Leaflets();

		$week_all_registrations = $model::with(['winners','participant','location','gift'])
    ->where('type','gift')
    ->whereNotNull('online_raffle')
    ->get();

		if(count($week_all_registrations)){
			(new FastExcel($week_all_registrations))->export('claimed_winners.xlsx', function ($user) {
			    return [
			        'Mobile' => empty($user['participant']['mobile']) ? '' : $user['participant']['mobile'],
			        'Location' => $user['location']['description'],
			        'Full Name' => empty($user['participant']['fullname']) ? '' : $user['participant']['fullname'],
			        'Age' => empty($user['participant']['age']) ? '' : $user['participant']['age'],
              'Gift' => empty($user['gift']) ? '' : $user['gift']['name'],
              // 'Claimed' => empty($user['winners']) ? 'No' : 'Yes',
              'Language' => empty($user['participant']['locale']) ? '' : $user['participant']['locale'],
			        'Created' => $user['CreatedTime'],
			        'Last Updated' => $user['UpdatedTime'],
			    ];
			});
		    return response()->download('claimed_winners.xlsx');
	    }
	        return response()->json('No download found for this week');
	}


}
