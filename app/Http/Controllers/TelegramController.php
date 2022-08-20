<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\FileUpload\InputFile;

use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function updatedActivity()
     {
        $activity = Telegram::getUpdates();
        dd($activity);
     }



     public function sendMessage()
     {
         return view('telegramView');
     }

     public function storeMessage(Request $request)
     {
         $request->validate([
             'name' => 'required',
             'message' => 'required'
         ]);

         $text =  "<b>#SURATJALAN</b>\n"
             .  "<b>No. Nota Surat Jalan: </b>\n"
             . "$request->name\n"
             . "<b>Customer: </b>\n"
             . $request->message;

         Telegram::sendMessage([
             'chat_id' => '-563689763',
             'parse_mode' => 'HTML',
             'text' => $text
         ]);

         return redirect()->back();
     }

     public function storePhoto(Request $request)
     {
         $request->validate([
             'file' => 'file|mimes:jpeg,png,gif,pdf'
         ]);

         $photo = $request->file('file');

         Telegram::sendPhoto([
             'chat_id' => '-563689763',
             'photo' => InputFile::createFromContents(file_get_contents($photo->getRealPath()), str_random(10) . '.' . $photo->getClientOriginalExtension()),
             'caption' => '#FOTOSURATJALAN',
         ]);

         return redirect()->back();
     }


}
