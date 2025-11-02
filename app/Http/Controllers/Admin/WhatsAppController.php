<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    public function index()
    {
        $settings = WhatsAppSetting::getSettings();

        return view('admin.whatsapp', compact('settings'));
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|max:20',
            'business_name' => 'required|string|max:255',
            'welcome_message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check your input and try again.');
        }

        $settings = WhatsAppSetting::first();
        
        if (!$settings) {
            $settings = new WhatsAppSetting();
        }

        $oldPhone = $settings->phone_number ?? null;
        $settings->phone_number = $request->phone_number;
        $settings->business_name = $request->business_name;
        $settings->welcome_message = $request->welcome_message;
        $settings->enable_chat_widget = $request->has('enable_whatsapp');
        $settings->save();

        Log::info('WhatsApp settings updated', [
            'phone_number' => $settings->phone_number,
            'enable_chat_widget' => $settings->enable_chat_widget,
            'old_phone' => $oldPhone
        ]);

        return redirect()->back()->with('success', 'WhatsApp settings saved successfully!');
    }
}
