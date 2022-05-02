<?php

namespace LaraCar\Http\Controllers\Admin;

use Illuminate\Http\Request;
use LaraCar\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use LaraCar\User;
use Illuminate\Support\Facades\Mail;
use LaraCar\Mail\Admin\Contact;
use Illuminate\Support\Str;

class PaymentController extends Controller
{

    public function payment()
    {
        $user = User::where('id', Auth::user()->id)->first();
        $credits = $user->ads_limit;
        return view('admin.payment.index', [
            'credits' => $credits
        ]);
    }

    public function contact()
    {
        return view('admin.payment.contact');
    }

    public function sendContact(Request $request)
    {

        if (empty($request['file']) && empty($request['message'])) {
            return redirect()->route('admin.contact')
                ->with(['color' => 'orange', 'message' => 'Preencha ao menos um dos campos!']);
        }

        $user = Auth::user();

        $validated = $request->validate([
            'file' => 'file|max:3000'
        ]);

        $data = [
            'reply_name' => $user->name,
            'reply_email' => $user->email,
            'cell' => $user->cell,
            'message' => $request->message ?? 'O usuário não encaminhou nenhum texto como mensagem'
        ];

        if (!empty($request->file('file'))) {
            $anexo = $request->file('file')
                ->storeAs('email', Str::slug('Anexo-' . $user->name) . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('file')
                    ->extension());

            $data['file'] = $anexo;
        }

        Mail::send(new Contact($data));

        return redirect()->route('admin.contact')
            ->with(['color' => 'green', 'message' => 'Contato enviado com sucesso!']);
    }

    public function banner()
    {
        return view('admin.payment.banner');
    }
}
