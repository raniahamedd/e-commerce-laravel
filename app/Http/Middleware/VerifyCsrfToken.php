<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // خارجي  apllecation من  Request  ازا انا راح يجيني
        // بضيفه هناCSRF Token بروح بضيف الروات الي بدي اسثتنيه من عملية فحص ال
        //عن طريق انه احط الروات بهاي المنطقة  Csrf فمش راح يزبط الوضع الا انه استثني هذا الراوت الي بتبعته باي بال من عملية فحص ال  CSRF Token مثلا لما باي بال تبعتلي ريكويست على السيرفر تبعي بطريقة البوست وطريقة البوست عندي لازم تمر على
//     /paybal/webhook 
    ];
}
