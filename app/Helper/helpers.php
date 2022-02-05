<?php

use App\Notification;
use Illuminate\Support\Facades\Auth;

function total()
{
  $total = Notification::where('read', 'false')->get()->count();
  return $total;
}

// function notifs()
// {
//   if (Auth::user()->hasRole('admin')) {
//     $notif = Notification::all()->paginate(5);
//   } elseif (Auth::user()->hasRole('nasabah')) {
//     $notif = Notification::where('user_id', Auth::user()->id)->paginate(5);
//   }
//   return $notif;
// }
