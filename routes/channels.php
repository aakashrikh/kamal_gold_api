<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Vendor;
use App\Models\UserOrders;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('NotificationChannel.{vendor_id}', function ($user,$vendor_id) {
    return (int) $user->id === (int) $vendor_id;
});


 Broadcast::channel('checkTableStatus.{vendor_id}', function ($user,$vendor_id) {
    return (int) $user->id === (int) $vendor_id;
});


Broadcast::channel('KotstatusChannel.{vendor_id}', function ($user,$vendor_id) {
    return (int) $user->id === (int) $vendor_id;
});

Broadcast::channel('DashboardOrderChannel.{vendor_id}', function ($user,$vendor_id) {
    return (int) $user->id === (int) $vendor_id;
});

Broadcast::channel('OrderstatusChannel.{order_id}', function ($user,$order_id) {

   $order= UserOrders::where('order_code',$order_id)->get();

   if($order[0]->user_id ==(int) $user->id || $order[0]->vendor_id ==(int) $user->id)
    {
        return true;
    }
    else
    {
        return false;
    }
});


// Broadcast::channel('checkTableStatus.{vendor_id}', function (Vendor $vendor, $vendor_id) {
//     return true;
// });


// Broadcast::channel('checkTableStatus.{orderId}', function ($vendor,$orderID) {

//     return true;
// });
//Broadcast::channel('checkTableStatus.{vendorId}', function ($vendor, $vendorId) {
//    return $vendor->id === Vendor::find($vendorId)->id;
//});
