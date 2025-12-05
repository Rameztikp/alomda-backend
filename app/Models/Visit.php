<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Stevebauman\Location\Facades\Location;

class Visit extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'browser',
        'platform',
        'device',
        'page_url',
        'referrer',
        'country',
        'city'
    ];

    public static function createFromRequest()
    {
        $ip = Request::ip();
        $userAgent = Request::header('User-Agent');
        
        // Get location data
        $location = Location::get($ip);
        
        // Parse user agent
        $browser = self::getBrowser($userAgent);
        $platform = self::getPlatform($userAgent);
        $device = self::getDevice($userAgent);

        return self::create([
            'ip_address' => $ip,
            'user_agent' => $userAgent,
            'browser' => $browser,
            'platform' => $platform,
            'device' => $device,
            'page_url' => Request::fullUrl(),
            'referrer' => Request::header('referer'),
            'country' => $location ? $location->countryName : null,
            'city' => $location ? $location->cityName : null,
        ]);
    }

    protected static function getBrowser($userAgent)
    {
        if (strpos($userAgent, 'Chrome')) return 'Chrome';
        if (strpos($userAgent, 'Safari')) return 'Safari';
        if (strpos($userAgent, 'Firefox')) return 'Firefox';
        if (strpos($userAgent, 'Edge')) return 'Edge';
        if (strpos($userAgent, 'MSIE') || strpos($userAgent, 'Trident/')) return 'Internet Explorer';
        return 'Other';
    }

    protected static function getPlatform($userAgent)
    {
        if (strpos($userAgent, 'Windows')) return 'Windows';
        if (strpos($userAgent, 'Mac')) return 'Mac';
        if (strpos($userAgent, 'Linux')) return 'Linux';
        if (strpos($userAgent, 'Android')) return 'Android';
        if (strpos($userAgent, 'iPhone') || strpos($userAgent, 'iPad')) return 'iOS';
        return 'Other';
    }

    protected static function getDevice($userAgent)
    {
        if (strpos($userAgent, 'Mobile')) return 'Mobile';
        if (strpos($userAgent, 'Tablet')) return 'Tablet';
        return 'Desktop';
    }
}
