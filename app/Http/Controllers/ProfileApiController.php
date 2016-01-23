<?php namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller as BaseController;

class ProfileApiController extends BaseController
{
    public function getProfile($id)
    {
        $profile = User::findOrFail($id);
        return $profile->toJson();
    }
}
