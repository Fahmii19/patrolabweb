<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestingController extends Controller
{
    public function redis_reset()
    {
        $result = redis_reset_api('user');
        return response()->json(json_decode($result));
    }

    public function get_image()
    {
        $imageResponse = get_image_api('1704945869329898abd7bdfa14994aebdb23c4dca9e09.png');
        if ($imageResponse !== null) {
            // Display the image using the <img> tag
            $base64Image = base64_encode($imageResponse);
            echo '<img src="data:image/*;base64,' . $base64Image . '" />';
        } else {
            // Handle the case where the image is not found
            echo 'Image not found';
        }
    }
}

// 1704945869329898abd7bdfa14994aebdb23c4dca9e09.png
// 170494756701184c9aa5c2bc044fa91d22881208b7d01.png