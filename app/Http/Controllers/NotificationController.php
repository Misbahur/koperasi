<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
  public function index()
  {
    $not = Notification::orderBy('created_at', 'desc')->first();
    $notif = Notification::paginate(5);
    return view('admin.notification.index', compact('notif', 'not'));
  }

  public function show($slug)
  {
    $notif = Notification::where('slug', $slug)->first();
    if ($notif->read == 'false') {
      Notification::where('slug', $slug)->update(['read' => 'true']);
    }
    return view('admin.notification.detail', compact('notif'));
  }

  public function store(Request $request)
  {
    Notification::create([
      'user_id' => $request->user_id,
      'type' => $request->type,
      'slug' => Str::random(6) . "==",
      'message' => $request->message,
      'read' => 'false',
    ]);
  }
}
