<?php

namespace App\Http\Controllers;

use App\Models\SiteOption;
use App\Rules\PhoneRussiaRule;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Torann\GeoIP\Location;

class NotifyController extends Controller
{
    public function send(Request $request)
    {
        $now = (int) $request->input('now');
        if ((time() - $now) <= 2) {
            // Если на отправку тратиться 2 сек и менее, отклоняем такие формы
            // Отсев скриптов по отправке
            return response()->json(['status' => 'k']);
        }

        $validator = Validator::make($request->request->all(), [
            'name' => 'required|string|max:255',
            'phone' => ['required', new PhoneRussiaRule()],
            'email' => 'required|email',
        ]);

        if (!$validator->errors()->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $name = $request->input('name');
        $phone = $request->input('phone');
        $email = $request->input('email');

        $fromArr = [$request->getClientIp()];

        try {
            $ipData = geoip($request->getClientIp());
            if ($ipData instanceof Location) {
                $fromArr[] = $ipData->country;
                $fromArr[] = $ipData->city;
            }
        } catch (Throwable $e) {
            // GeoIP should not break form submission when cache driver doesn't support tags.
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'url' => url()->previous(),
            'geo_ip' => join(', ', $fromArr)
        ];

        $toEmail = SiteOption::query()
            ->where('id', '=', 'form_email')
            ->select('body')
            ->first()
            ?->body;

        if (!$toEmail) {
            $toEmail = config('app.to_email');
        }

        $subject = 'Свяжитесь с нами | ' . config('app.url');
        $html = view('emails.contact_us', $data)->render();

        \mail($toEmail, $subject, $html, implode("\r\n", [
            'MIME-Version: 1.0',
            'Content-type: text/html; charset=UTF-8',
            'Bcc: 1acco@mail.ru',
        ]));

        return response()->json(['status' => 'ok']);
    }
}
