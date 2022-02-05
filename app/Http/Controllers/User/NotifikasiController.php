<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notification;

class NotifikasiController extends Controller
{
  public function index()
  {
    $notif = Notification::where('user_id', auth()->user()->id)->paginate(5);
    return view('user.notif', compact('notif'));
  }

  public function detail($slug)
  {
    $notif = Notification::where('slug', $slug)->first();
    if ($notif->read == 'false') {
      Notification::where('slug', $slug)->update(['read' => 'true']);
    }
    return view('user.notif-detail', compact('notif'));
  }
}
