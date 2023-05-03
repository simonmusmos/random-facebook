<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index() {
        $response = Http::get('https://randomuser.me/api/');
        // $response = Http::get('http://metaphorpsum.com/paragraphs/2/4');
        // echo($response->body());
        // return;
        $data = json_decode($response->body())->results[0];
// dd($data);
        $data_encoded = json_encode($data);
        return view('welcome', [
            'data' => $data,
            'data_encoded' => $data_encoded,
        ]);
    }

    public function getUserPosts() {
        $posts = [];
        for ($i = 0; $i < 3; $i++) {
            $has_image = rand(0,1);
            $posts[] = [
                'message' => (($has_image == 1 && rand(0,1) == 1) || ($has_image == 0)) ? Http::get('http://metaphorpsum.com/paragraphs/1/5')->body() : '',
                'has_image' => $has_image
            ];
        }
        return response()->json($posts);
    }

    public function store(Request $request) {
        $data = json_decode(htmlspecialchars_decode($request->json_data));
        
        $user = User::create([
            'name' => $data->name->first . ' ' . $data->name->last,
            'email' => $data->email,
            'password'=> Hash::make($data->login->password),
        ]);
        $user_details = UserDetail::create([
            'user_id' => $user->id,
            'details' => htmlspecialchars_decode($request->json_data),
        ]);

        if ($user_details) {
            return true;
        }

        return false;
    }

    public function list() {
        $users = User::paginate(10);
        return view('list', [
            'users' => $users,
        ]);
    }

    public function info(User $user) {
        $details = json_decode($user->userDetail->details);
        $info = [
            'name' => $user->name,
            'profile' => $details->picture->thumbnail,
            'banner' => 'https://picsum.photos/500/500?random=' . rand(1,20),
            'gender' => ucfirst($details->gender),
            'email' => $details->email,
            'phone' => $details->phone,
            'cell' => $details->cell,
            'location' => $details->location->city  . ',' . $details->location->state . ',' . $details->location->country,
        ];

        return response()->json(['info' => $info]);
    }

    public function destroy(User $user) {
        $user->userDetail()->delete();
        $user->delete();
        return redirect()->back();
    }
}
